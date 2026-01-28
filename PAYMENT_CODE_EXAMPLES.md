# Payment System Code Examples & Integration Guide

## Complete Payment Flow Example

### 1. User Books an Event (Controller)

```php
// BookingController@store
public function store(Request $request)
{
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'event_id' => $request->event_id,
        'ticket_id' => $request->ticket_id,
        'booking_date' => now(),
        'status' => 'confirmed', // Not yet paid
    ]);

    // Redirect to payment
    return redirect()->route('payments.create.for.booking', $booking);
}
```

### 2. Payment Checkout Page

```php
// PaymentController@createForBooking
public function createForBooking(Booking $booking)
{
    $booking->load(['event', 'ticket', 'user']);
    $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
    
    return view('payments.create_for_booking', compact('booking', 'paymentMethods'));
}
```

### 3. Process Payment

```php
// PaymentController@store
public function store(Request $request)
{
    $booking = Booking::findOrFail($request->booking_id);

    // Process via service
    $result = $this->paymentService->processPayment(
        $booking,
        $request->payment_method,  // 'virtual' or 'stripe'
        ['card_type' => 'Virtual Card']
    );

    if ($result['success']) {
        return redirect()->route('payments.show', $result['payment_id']);
    } else {
        return back()->withErrors(['payment' => $result['message']]);
    }
}
```

### 4. PaymentService Processing

```php
// PaymentService@processPayment (simplified)
public function processPayment(Booking $booking, string $paymentMethod, array $paymentDetails)
{
    if ($paymentMethod === 'stripe') {
        return $this->processStripePayment($booking, $paymentDetails);
    } else {
        return $this->processVirtualPayment($booking, $paymentDetails);
    }
}

// Virtual payment
public function processVirtualPayment(Booking $booking, array $paymentDetails)
{
    $amount = $booking->ticket->price;
    $transactionId = 'TXN_' . Str::random(12);

    // Create payment record
    $payment = Payment::create([
        'booking_id' => $booking->id,
        'amount' => $amount,
        'payment_method' => 'virtual',
        'payment_date' => now(),
        'transaction_id' => $transactionId,
        'status' => 'completed',
    ]);

    // Update booking
    $booking->update(['status' => 'paid', 'payment_id' => $payment->id]);

    return [
        'success' => true,
        'message' => 'Payment processed successfully',
        'payment_id' => $payment->id,
        'transaction_id' => $transactionId,
    ];
}
```

---

## Using PaymentService Directly

### In a Command or Scheduled Task

```php
// Example: Process pending payments
$pendingBookings = Booking::where('status', 'confirmed')->get();

foreach ($pendingBookings as $booking) {
    $paymentService = app(\App\Services\PaymentService::class);
    
    $result = $paymentService->processPayment(
        $booking,
        'virtual',
        []
    );

    if ($result['success']) {
        Log::info("Automated payment processed: {$result['transaction_id']}");
    }
}
```

### Refunding a Payment

```php
// RefundController or similar
public function refundPayment(Payment $payment)
{
    $paymentService = app(\App\Services\PaymentService::class);
    $result = $paymentService->refundPayment($payment);

    if ($result['success']) {
        // Payment refunded, booking cancelled
        return redirect()->back()->with('status', 'Refund processed successfully');
    } else {
        return redirect()->back()->withErrors(['refund' => $result['message']]);
    }
}
```

### Verifying Payment Status

```php
// API endpoint for checking payment status
Route::get('/api/payments/{payment}/verify', function (Payment $payment) {
    $paymentService = app(\App\Services\PaymentService::class);
    $status = $paymentService->verifyPaymentStatus($payment);

    return response()->json($status);
})->middleware('auth');
```

---

## Frontend Integration

### HTML Form for Payment

```html
<form action="{{ route('payments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

    <!-- Payment Method Selection -->
    <div class="space-y-3">
        @foreach($paymentMethods as $method)
            <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                <input type="radio" 
                       name="payment_method" 
                       value="{{ $method['id'] }}" 
                       class="w-4 h-4"
                       {{ $loop->first ? 'checked' : '' }}>
                <div class="ml-3">
                    <span class="font-semibold">{{ $method['name'] }}</span>
                    <p class="text-sm text-gray-600">{{ $method['description'] }}</p>
                </div>
            </label>
        @endforeach
    </div>

    <!-- Booking Summary -->
    <div class="bg-gray-50 p-4 rounded-lg mb-4">
        <h3>Booking Summary</h3>
        <p>Event: {{ $booking->event->name }}</p>
        <p>Amount: ${{ number_format($booking->ticket->price, 2) }}</p>
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">
        Process Payment
    </button>
</form>
```

### JavaScript for Real-time Payment Status

```javascript
// Check payment status every 5 seconds
function checkPaymentStatus(paymentId) {
    fetch(`/api/payments/${paymentId}/verify`)
        .then(response => response.json())
        .then(data => {
            if (data.verified) {
                console.log('✅ Payment verified:', data);
                showSuccessMessage(data.message);
                redirectToDashboard();
            } else if (data.status === 'pending') {
                console.log('⏳ Payment pending...');
                setTimeout(() => checkPaymentStatus(paymentId), 5000);
            } else {
                console.log('❌ Payment failed:', data);
                showErrorMessage(data.message);
            }
        });
}
```

---

## Stripe Integration Details

### Setting Up Stripe

```php
// In PaymentService::processStripePayment()

\Stripe\Stripe::setApiKey(config('services.stripe.secret'));

$paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => (int)($booking->ticket->price * 100), // In cents
    'currency' => 'usd',
    'payment_method' => $paymentDetails['payment_method_id'],
    'confirm' => true,
    'metadata' => [
        'booking_id' => $booking->id,
        'event_name' => $booking->event->name,
        'user_id' => $booking->user_id,
    ],
]);

if ($paymentIntent->status === 'succeeded') {
    // Payment successful
    return $this->createPaymentRecord($booking, $paymentIntent);
}
```

### Stripe Test Cards

```
Visa: 4242 4242 4242 4242
Mastercard: 5555 5555 5555 4444
American Express: 3782 822463 10005

Expiry: Any future date (e.g., 12/25)
CVC: Any 3 digits (e.g., 123)
```

### Webhook Handling (Advanced)

```php
// routes/api.php
Route::post('/webhooks/stripe', function (Request $request) {
    $signature = $request->header('Stripe-Signature');
    $payload = $request->getContent();
    
    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $signature,
            config('services.stripe.webhook_secret')
        );

        switch ($event->type) {
            case 'payment_intent.succeeded':
                // Handle successful payment
                break;
            case 'payment_intent.payment_failed':
                // Handle failed payment
                break;
        }

        return response()->json(['received' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
});
```

---

## Error Handling Examples

### Try-Catch Pattern

```php
try {
    $result = $paymentService->processPayment($booking, 'stripe', $details);
    
    if ($result['success']) {
        // Log successful payment
        Log::info("Payment processed: {$result['transaction_id']}");
        
        return redirect()->route('payments.show', $result['payment_id']);
    } else {
        // Log failed payment
        Log::warning("Payment failed: {$result['message']}");
        
        return back()->withErrors(['payment' => $result['message']]);
    }
} catch (\Exception $e) {
    // Log unexpected error
    Log::error("Payment error: {$e->getMessage()}");
    
    return back()->withErrors(['payment' => 'Payment processing error. Please try again.']);
}
```

### Validation Example

```php
public function validatePaymentData($booking, $paymentMethod)
{
    if (!$booking) {
        throw new \Exception('Booking not found');
    }

    if ($booking->status === 'paid') {
        throw new \Exception('Booking already paid');
    }

    if (!in_array($paymentMethod, ['virtual', 'stripe'])) {
        throw new \Exception('Invalid payment method');
    }

    if (!$booking->ticket || $booking->ticket->price < 0) {
        throw new \Exception('Invalid ticket or price');
    }

    return true;
}
```

---

## Database Query Examples

### Get All Payments for a User

```php
$userPayments = Payment::with('booking')
    ->whereHas('booking', function ($query) {
        $query->where('user_id', auth()->id());
    })
    ->orderBy('created_at', 'desc')
    ->get();
```

### Get Failed Payments

```php
$failedPayments = Payment::where('status', 'failed')
    ->orWhere('status', 'pending')
    ->where('created_at', '<', now()->subDays(7))
    ->get();
```

### Get Payment Statistics

```php
$stats = [
    'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
    'total_refunded' => Payment::where('status', 'refunded')->sum('amount'),
    'pending_payments' => Payment::where('status', 'pending')->count(),
    'failed_payments' => Payment::where('status', 'failed')->count(),
];
```

---

## Testing Examples

### Unit Test

```php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Booking;
use App\Services\PaymentService;

class PaymentServiceTest extends TestCase
{
    public function test_process_virtual_payment()
    {
        $booking = Booking::factory()->create();
        $service = new PaymentService();
        
        $result = $service->processPayment($booking, 'virtual');
        
        $this->assertTrue($result['success']);
        $this->assertStringStartsWith('TXN_', $result['transaction_id']);
        $this->assertEquals('completed', $result['payment_method']);
    }

    public function test_refund_payment()
    {
        $payment = Payment::factory()->create(['status' => 'completed']);
        $service = new PaymentService();
        
        $result = $service->refundPayment($payment);
        
        $this->assertTrue($result['success']);
        $this->assertEquals('refunded', $payment->fresh()->status);
    }
}
```

### Feature Test

```php
public function test_complete_payment_flow()
{
    $user = User::factory()->create();
    $booking = Booking::factory()->create(['user_id' => $user->id]);
    
    $response = $this->actingAs($user)
        ->post(route('payments.store'), [
            'booking_id' => $booking->id,
            'payment_method' => 'virtual',
        ]);
    
    $this->assertDatabaseHas('payments', [
        'booking_id' => $booking->id,
        'status' => 'completed',
    ]);
    
    $response->assertRedirect();
}
```

---

## Performance Optimization

### Eager Loading Relationships

```php
// Avoid N+1 queries
$bookings = Booking::with(['event', 'ticket', 'user', 'payment'])
    ->where('user_id', auth()->id())
    ->get();
```

### Caching Payment Methods

```php
$paymentMethods = Cache::remember('payment_methods', 3600, function () {
    return $this->paymentService->getAvailablePaymentMethods();
});
```

### Batch Processing

```php
// Process multiple payments
Payment::where('status', 'pending')
    ->where('created_at', '<', now()->subDays(1))
    ->chunkById(100, function ($payments) {
        foreach ($payments as $payment) {
            $this->paymentService->verifyPaymentStatus($payment);
        }
    });
```

---

## Debugging Tips

### Enable Payment Logging

```php
// In PaymentService
Log::info('Payment processing started', [
    'booking_id' => $booking->id,
    'method' => $paymentMethod,
    'amount' => $booking->ticket->price,
]);
```

### Check Transaction Status

```php
// In tinker
$payment = Payment::find(1);
dd($payment->toArray()); // See all payment data
```

### View Payment Metadata

```php
$payment = Payment::find(1);
echo json_encode($payment->metadata, JSON_PRETTY_PRINT);
```

---

**End of Code Examples**

For more information, see the full PaymentService implementation in `app/Services/PaymentService.php`
