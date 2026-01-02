<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = \App\Models\Booking::with(['event', 'ticket'])->get();
        return view('payments.create', compact('bookings'));
    }

    public function createForBooking(\App\Models\Booking $booking)
    {
        $booking->load(['event', 'ticket']);
        return view('payments.create_for_booking', compact('booking'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ]);

        Payment::create($data);
        return redirect()->route('payments.show', Payment::latest()->first())->with('status', 'Payment processed successfully.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $bookings = \App\Models\Booking::with(['event', 'ticket'])->get();
        return view('payments.edit', compact('payment', 'bookings'));
    }

    public function update(Request $request, Payment $payment)
    {
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
        $payment->delete();
        return redirect()->route('payments.index');
    }
}