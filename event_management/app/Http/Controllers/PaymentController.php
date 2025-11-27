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

    public function store(Request $request)
    {
        Payment::create($request->all());
        return redirect()->route('payments.index');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index');
    }
}