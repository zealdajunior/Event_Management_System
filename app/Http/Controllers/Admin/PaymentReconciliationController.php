<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentReconciliationController extends Controller
{
    /**
     * Show payment reconciliation dashboard
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $status = $request->input('status', 'all');

        // Get payments with filtering
        $query = Payment::with(['booking.event', 'booking.user'])
            ->whereBetween('payment_date', [$startDate, $endDate]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(50);

        // Calculate statistics
        $stats = $this->calculateReconciliationStats($startDate, $endDate);

        // Get unmatched payments
        $unmatchedPayments = $this->getUnmatchedPayments();

        // Get recent webhook logs
        $recentWebhooks = DB::table('payment_webhook_logs')
            ->orderBy('received_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.payments.reconciliation', compact(
            'payments',
            'stats',
            'unmatchedPayments',
            'recentWebhooks',
            'startDate',
            'endDate',
            'status'
        ));
    }

    /**
     * Calculate reconciliation statistics
     */
    protected function calculateReconciliationStats($startDate, $endDate)
    {
        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])->get();

        return [
            'total_payments' => $payments->count(),
            'total_amount' => $payments->sum('amount'),
            'completed_payments' => $payments->where('status', 'completed')->count(),
            'completed_amount' => $payments->where('status', 'completed')->sum('amount'),
            'pending_payments' => $payments->where('status', 'pending')->count(),
            'pending_amount' => $payments->where('status', 'pending')->sum('amount'),
            'failed_payments' => $payments->where('status', 'failed')->count(),
            'failed_amount' => $payments->where('status', 'failed')->sum('amount'),
            'refunded_payments' => $payments->where('status', 'refunded')->count(),
            'refunded_amount' => $payments->where('status', 'refunded')->sum('amount'),
            'webhook_verified' => $payments->whereNotNull('webhook_verified_at')->count(),
            'webhook_unverified' => $payments->whereNull('webhook_verified_at')->count(),
        ];
    }

    /**
     * Get unmatched payments (payments without webhook confirmation)
     */
    protected function getUnmatchedPayments()
    {
        return Payment::whereNull('webhook_verified_at')
            ->where('status', 'completed')
            ->where('payment_method', '!=', 'virtual')
            ->where('created_at', '>', now()->subDays(7))
            ->with(['booking.event', 'booking.user'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * Manually verify a payment
     */
    public function verifyPayment(Payment $payment)
    {
        $paymentService = app(\App\Services\PaymentService::class);
        $result = $paymentService->verifyPaymentStatus($payment);

        if ($result['verified']) {
            $payment->update(['webhook_verified_at' => now()]);
            return back()->with('success', 'Payment verified successfully');
        }

        return back()->with('error', $result['message'] ?? 'Payment verification failed');
    }

    /**
     * Export reconciliation report
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $payments = Payment::with(['booking.event', 'booking.user'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->orderBy('payment_date', 'desc')
            ->get();

        $csv = $this->generateCSV($payments);

        $filename = 'payment_reconciliation_' . $startDate . '_to_' . $endDate . '.csv';

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Generate CSV from payments
     */
    protected function generateCSV($payments)
    {
        $output = fopen('php://temp', 'r+');

        // Headers
        fputcsv($output, [
            'Payment ID',
            'Transaction ID',
            'Booking ID',
            'Event Name',
            'User Name',
            'User Email',
            'Amount',
            'Payment Method',
            'Status',
            'Payment Date',
            'Webhook Verified',
            'Verified At',
        ]);

        // Data rows
        foreach ($payments as $payment) {
            fputcsv($output, [
                $payment->id,
                $payment->transaction_id,
                $payment->booking_id,
                $payment->booking->event->name ?? 'N/A',
                $payment->booking->user->name ?? 'N/A',
                $payment->booking->user->email ?? 'N/A',
                $payment->amount,
                $payment->payment_method,
                $payment->status,
                $payment->payment_date->format('Y-m-d H:i:s'),
                $payment->webhook_verified_at ? 'Yes' : 'No',
                $payment->webhook_verified_at ? $payment->webhook_verified_at->format('Y-m-d H:i:s') : 'N/A',
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }

    /**
     * Reconcile payment with booking
     */
    public function reconcile(Request $request, Payment $payment)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Update payment with correct booking
        $payment->update([
            'booking_id' => $booking->id,
            'reconciled_at' => now(),
        ]);

        // Update booking status
        if ($payment->status === 'completed') {
            $booking->update(['status' => 'paid']);
        }

        return back()->with('success', 'Payment reconciled successfully with booking #' . $booking->id);
    }

    /**
     * Auto-reconcile payments
     */
    public function autoReconcile()
    {
        if (!config('payments.reconciliation.auto_match')) {
            return back()->with('error', 'Auto-reconciliation is disabled');
        }

        $reconciled = 0;
        $unmatchedPayments = $this->getUnmatchedPayments();

        foreach ($unmatchedPayments as $payment) {
            // Try to match by transaction ID or amount
            $paymentService = app(\App\Services\PaymentService::class);
            $result = $paymentService->verifyPaymentStatus($payment);

            if ($result['verified']) {
                $payment->update(['webhook_verified_at' => now()]);
                $reconciled++;
            }
        }

        return back()->with('success', "Auto-reconciled {$reconciled} payments");
    }

    /**
     * View webhook logs
     */
    public function webhookLogs(Request $request)
    {
        $provider = $request->input('provider', 'all');
        $startDate = $request->input('start_date', now()->subDays(7)->format('Y-m-d'));

        $query = DB::table('payment_webhook_logs')
            ->where('received_at', '>=', $startDate);

        if ($provider !== 'all') {
            $query->where('provider', $provider);
        }

        $logs = $query->orderBy('received_at', 'desc')->paginate(50);

        return view('admin.payments.webhook-logs', compact('logs', 'provider', 'startDate'));
    }
}
