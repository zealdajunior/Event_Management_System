<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $payments = Payment::with('booking')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::with(['event', 'ticket'])->where('status', '!=', 'paid')->get();
        $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
        return view('payments.create', compact('bookings', 'paymentMethods'));
    }

    public function createForBooking(Booking $booking)
    {
        // Verify user owns this booking
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $booking->load(['event', 'ticket', 'user']);
        $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
        return view('payments.create_for_booking', compact('booking', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:virtual,stripe',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Verify user owns this booking
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Check if booking is already paid
        if ($booking->status === 'paid') {
            return back()->withErrors(['booking_id' => 'This booking is already paid']);
        }

        $paymentDetails = [];
        if ($request->payment_method === 'virtual') {
            $paymentDetails = [
                'card_type' => 'Virtual Card',
                'last_four' => '0000',
            ];
        } elseif ($request->payment_method === 'stripe') {
            $paymentDetails = [
                'payment_method_id' => $request->input('stripe_payment_method_id'),
            ];
        }

        // Process payment
        $result = $this->paymentService->processPayment(
            $booking,
            $request->payment_method,
            $paymentDetails
        );

        if ($result['success']) {
            return redirect()->route('payments.show', $result['payment_id'])
                ->with('status', $result['message']);
        } else {
            return back()->withErrors(['payment' => $result['message']]);
        }
    }

    public function show(Payment $payment)
    {
        // Verify user can view this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $payment->load(['booking.event', 'booking.ticket', 'booking.user']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        // Verify user can edit this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $bookings = Booking::with(['event', 'ticket'])->get();
        $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
        return view('payments.edit', compact('payment', 'bookings', 'paymentMethods'));
    }

    public function update(Request $request, Payment $payment)
    {
        // Verify user can update this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ]);

        $payment->update($data);
        return redirect()->route('payments.show', $payment)->with('status', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        // Verify user can delete this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $payment->delete();
        return redirect()->route('payments.index')->with('status', 'Payment deleted successfully.');
    }

    /**
     * Refund a payment
     */
    public function refund(Payment $payment)
    {
        // Verify user can refund this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $result = $this->paymentService->refundPayment($payment);

        if ($result['success']) {
            return back()->with('status', $result['message']);
        } else {
            return back()->withErrors(['payment' => $result['message']]);
        }
    }

    /**
     * Verify payment status with payment provider
     */
    public function verify(Payment $payment)
    {
        // Verify user can view this payment
        if ($payment->booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $result = $this->paymentService->verifyPaymentStatus($payment);

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        if ($result['verified']) {
            return back()->with('status', 'Payment verified successfully');
        } else {
            return back()->withErrors(['payment' => $result['message']]);
        }
    }
}
