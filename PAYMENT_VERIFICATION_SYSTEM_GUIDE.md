# Complete Payment & Verification System Guide

## Overview
This implementation provides a comprehensive event management system with:
- **Automated revenue sharing** between event organizers and platform
- **Event approval workflow** with identity verification
- **Secure document verification** for event authenticity
- **Automatic payout management** for organizers

## Architecture

### 1. Revenue Sharing System

#### How it Works
When a user purchases a ticket:
1. Payment is processed through Stripe (already implemented)
2. `PaymentObserver` automatically triggers when payment status becomes "completed"
3. `RevenueService` splits the payment:
   - **Platform Fee**: 10% (configurable in `.env` with `PLATFORM_FEE_PERCENTAGE`)
   - **Organizer Earnings**: 90%
4. Revenue record is created in `event_revenue` table with status "pending"
5. After event ends + 7 days safety period, revenue becomes "available"
6. Organizer can request payout through their dashboard

#### Database Tables

**event_revenue**
- Tracks each ticket sale and revenue split
- Fields: `total_amount`, `platform_fee`, `organizer_earnings`, `status`
- Statuses: `pending` → `available` → `paid`

**organizer_payouts**
- Tracks payout requests and processing
- Fields: `amount`, `payment_method`, `payment_details`, `status`
- Statuses: `pending` → `processing` → `completed` / `failed`

#### Configuration
Add to `.env`:
```env
PLATFORM_FEE_PERCENTAGE=10.00  # Platform takes 10%
PAYOUT_DELAY_DAYS=7            # Days after event before payout available
```

### 2. Event Approval Workflow

#### How it Works
1. **Event Creation**: Organizer creates event (status: `pending`)
2. **Verification Submission**: Organizer uploads identity documents
3. **Admin Review**: Admin reviews event + documents in approval dashboard
4. **Risk Assessment**: System calculates risk score (0-100) based on:
   - Missing identity documents (+30 points)
   - Unverified phone/email (+15 each)
   - High-value event without business registration (+20)
   - Unverified venue (+10)
   - Large event without permits (+10)
5. **Approval/Rejection**: Admin approves or rejects with notes
6. **Notification**: Organizer receives email notification
7. **Event Goes Live**: Only approved events visible to public

#### User Roles & Permissions
- **Organizer**: Can create events, submit verification, view earnings
- **Admin**: Can review/approve events, view all verifications, process payouts
- **Super Admin**: Full system access including platform revenue reports

### 3. Identity Verification

#### Required Documents
1. **Identity Verification**:
   - Government-issued ID (passport, driver's license, national ID)
   - ID number and expiry date

2. **Business Verification** (optional, for commercial events):
   - Business registration document
   - Business registration number
   - Tax ID

3. **Address Verification**:
   - Proof of address (utility bill, bank statement)

4. **Venue Verification**:
   - Venue confirmation
   - Required permits for large events (100+ attendees)

#### Document Storage
- All documents stored in Laravel's private storage (`storage/app/private/verifications/`)
- Organized by type: `identity/`, `business/`, `address/`, `permits/`
- Only admins can download verification documents
- Files are encrypted at rest

### 4. Security Features

#### Identity Checks
- ✅ Email verification (already implemented in Laravel)
- ✅ Phone number verification
- ✅ Government ID validation
- ✅ Address proof requirement
- ✅ Business registration for high-value events

#### Event Authenticity Checks
- ✅ Risk score calculation
- ✅ Venue verification
- ✅ Permit validation for large events
- ✅ Duplicate event detection (manual by admin)
- ✅ Suspicious pricing pattern detection (via risk score)
- ✅ Creator history review

#### Financial Security
- ✅ Escrow period: Funds held until event completion + 7 days
- ✅ Automatic revenue split with audit trail
- ✅ Payout approval workflow
- ✅ Transaction reference tracking
- ✅ Failed payout handling

## Implementation Steps

### Step 1: Run Migrations
```bash
cd event_management
php artisan migrate
```

This creates 5 new tables:
1. `event_revenue` - Revenue tracking and splitting
2. `organizer_payouts` - Payout management
3. `event_verifications` - Document and verification tracking
4. Adds columns to `events` table (approval_status, approved_by, etc.)
5. Adds columns to `users` table (identity_verified, phone_verified, etc.)

### Step 2: Configure Settings
Add to `.env`:
```env
# Revenue Sharing
PLATFORM_FEE_PERCENTAGE=10.00
PAYOUT_DELAY_DAYS=7

# File Storage
FILESYSTEM_DISK=local  # Use 'local' for development, 's3' for production
```

### Step 3: Add Routes
Add to `routes/web.php`:

```php
// Event Verification Routes (Organizers)
Route::middleware(['auth'])->group(function () {
    Route::get('/events/{event}/verification', [EventVerificationController::class, 'show'])
        ->name('events.verification.show');
    Route::post('/events/{event}/verification', [EventVerificationController::class, 'store'])
        ->name('events.verification.store');
});

// Admin Event Approval Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/events/approval', [EventApprovalController::class, 'index'])
        ->name('events.approval.index');
    Route::get('/events/{event}/approval', [EventApprovalController::class, 'show'])
        ->name('events.approval.show');
    Route::post('/events/{event}/approve', [EventApprovalController::class, 'approve'])
        ->name('events.approval.approve');
    Route::post('/events/{event}/reject', [EventApprovalController::class, 'reject'])
        ->name('events.approval.reject');
    Route::post('/events/approval/bulk-approve', [EventApprovalController::class, 'bulkApprove'])
        ->name('events.approval.bulk-approve');
    
    // Document download
    Route::get('/verifications/{verification}/document/{type}', [EventVerificationController::class, 'downloadDocument'])
        ->name('verifications.download');
});
```

### Step 4: Update Event Creation Flow
When creating an event, the system now:
1. Sets `approval_status` to `'pending'`
2. Redirects organizer to verification form
3. Waits for admin approval before going live

### Step 5: Create Admin Dashboard Views
You need to create these Blade views:

1. **Admin Approval Dashboard** (`resources/views/admin/events/approval/index.blade.php`)
   - List of pending events with risk scores
   - Quick approve/reject buttons
   - Search and filter options

2. **Event Approval Details** (`resources/views/admin/events/approval/show.blade.php`)
   - Full event details
   - Organizer information
   - Verification documents (viewable/downloadable)
   - Risk assessment breakdown
   - Approve/reject form with notes

3. **Verification Form** (`resources/views/events/verification.blade.php`)
   - Document upload fields
   - Identity information form
   - Business details (optional)
   - Address verification
   - Phone verification

4. **Email Templates**:
   - `resources/views/emails/events/approved.blade.php`
   - `resources/views/emails/events/rejected.blade.php`

### Step 6: Update Existing Event Queries
Update event queries to only show approved events to public:

```php
// Before
Event::where('status', 'active')->get();

// After
Event::where('status', 'active')
    ->where('approval_status', 'approved')
    ->get();
```

### Step 7: Add Earnings Dashboard for Organizers
Create a dashboard showing:
- Total earnings
- Pending revenue (locked until event ends)
- Available for payout
- Payout history
- Request payout button

## API Endpoints

### For Organizers
- `GET /events/{event}/verification` - Show verification form
- `POST /events/{event}/verification` - Submit verification documents
- `GET /organizer/earnings` - View earnings summary
- `POST /organizer/payout/request` - Request payout

### For Admins
- `GET /admin/events/approval` - List pending events
- `GET /admin/events/{event}/approval` - View event details
- `POST /admin/events/{event}/approve` - Approve event
- `POST /admin/events/{event}/reject` - Reject event
- `GET /admin/verifications/{verification}/document/{type}` - Download document
- `GET /admin/revenue/summary` - Platform revenue summary

## Usage Examples

### 1. Automatic Revenue Processing
```php
use App\Services\RevenueService;

$revenueService = app(RevenueService::class);

// Automatically triggered by PaymentObserver when payment completes
// No manual intervention needed!

// Get revenue summary for an event
$summary = $revenueService->getEventRevenueSummary($event);
// Returns: [
//     'total_revenue' => 5000.00,
//     'platform_fees' => 500.00,
//     'organizer_earnings' => 4500.00,
//     'pending' => 2000.00,
//     'available' => 2500.00,
//     'paid' => 0.00,
//     'ticket_count' => 50
// ]
```

### 2. Make Revenues Available After Event
```php
// Run this as scheduled job after events end
$event = Event::find(1);
$revenueService->makeRevenuesAvailable($event);
```

### 3. Create Payout for Organizer
```php
$payout = $revenueService->createOrganizerPayout($event);
// Creates payout record for all available revenues
```

### 4. Manual Event Approval
```php
use App\Models\Event;

$event = Event::find(1);

// Approve
$event->update([
    'approval_status' => 'approved',
    'approved_by' => auth()->id(),
    'approved_at' => now(),
]);

// Reject
$event->update([
    'approval_status' => 'rejected',
    'approved_by' => auth()->id(),
    'approved_at' => now(),
    'rejection_reason' => 'Insufficient verification documents',
]);
```

### 5. Risk Score Calculation
```php
$verification = EventVerification::find(1);
$riskScore = $verification->calculateRiskScore();
// Returns 0-100, higher = riskier
```

## Scheduled Jobs

Add to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Make revenues available after events end
    $schedule->call(function () {
        $completedEvents = Event::where('end_date', '<', now()->subDays(7))
            ->where('approval_status', 'approved')
            ->get();

        $revenueService = app(RevenueService::class);
        foreach ($completedEvents as $event) {
            $revenueService->makeRevenuesAvailable($event);
        }
    })->daily();

    // Send reminder to admins about pending approvals
    $schedule->call(function () {
        $pendingCount = Event::where('approval_status', 'pending')->count();
        if ($pendingCount > 0) {
            // Send notification to admins
        }
    })->dailyAt('09:00');
}
```

## Testing

### Test Revenue Split
```bash
php artisan tinker

# Create test payment
$payment = Payment::factory()->create([
    'amount' => 100.00,
    'status' => 'completed',
    'event_id' => 1
]);

# Check revenue was created
$revenue = EventRevenue::where('payment_id', $payment->id)->first();
echo "Total: {$revenue->total_amount}\n";
echo "Platform Fee: {$revenue->platform_fee}\n";
echo "Organizer: {$revenue->organizer_earnings}\n";
```

### Test Approval Workflow
```bash
# Create event (will be pending)
$event = Event::factory()->create(['user_id' => 1]);

# Submit verification
$verification = EventVerification::create([
    'event_id' => $event->id,
    'user_id' => 1,
    'id_document_type' => 'passport',
    'id_number' => 'AB123456',
    'status' => 'pending'
]);

# Calculate risk score
$verification->calculateRiskScore();

# Approve event
$event->update(['approval_status' => 'approved']);
```

## Monitoring & Analytics

### Key Metrics to Track
1. **Platform Revenue**: Sum of all platform_fee from event_revenue
2. **Pending Payouts**: Sum of organizer_payouts where status='pending'
3. **Average Risk Score**: AVG(risk_score) from event_verifications
4. **Approval Rate**: approved_events / total_events
5. **Average Approval Time**: AVG(approved_at - created_at)

### Queries for Admin Dashboard
```php
// Total platform revenue
$platformRevenue = EventRevenue::sum('platform_fee');

// Pending organizer payouts
$pendingPayouts = OrganizerPayout::where('status', 'pending')->sum('amount');

// Events awaiting approval
$pendingApprovals = Event::where('approval_status', 'pending')->count();

// High-risk events needing attention
$highRiskEvents = Event::where('approval_status', 'pending')
    ->whereHas('verification', fn($q) => $q->where('risk_score', '>=', 60))
    ->count();
```

## Security Best Practices

1. **Document Storage**:
   - Store verification documents in private storage (not public)
   - Use Laravel's `Storage::disk('private')` 
   - Implement access control (admin-only downloads)

2. **Financial Data**:
   - Log all revenue transactions
   - Use database transactions for payout creation
   - Implement audit trail for all status changes

3. **User Verification**:
   - Require email verification before event creation
   - Implement phone OTP verification
   - Validate ID expiry dates
   - Check for expired documents

4. **Admin Actions**:
   - Log all approve/reject actions with admin ID
   - Require reason for rejection
   - Implement role-based access control

## Troubleshooting

### Revenue Not Created
- Check if PaymentObserver is registered in AppServiceProvider
- Verify payment status is 'completed'
- Check logs in `storage/logs/laravel.log`

### Event Stays Pending
- Verify admin approval workflow is implemented
- Check if event has `approval_status = 'pending'`
- Ensure admin has access to approval dashboard

### Documents Not Uploading
- Check storage permissions: `php artisan storage:link`
- Verify `private` disk is configured in `config/filesystems.php`
- Check file size limits in php.ini

### Payout Not Available
- Verify event end_date + 7 days has passed
- Check revenue status is 'available'
- Run `makeRevenuesAvailable()` manually

## Next Steps

After implementation, you should:

1. ✅ Create admin approval dashboard UI
2. ✅ Create verification form UI for organizers
3. ✅ Create earnings dashboard for organizers
4. ✅ Set up email notifications (approval/rejection)
5. ✅ Add scheduled jobs for automatic revenue availability
6. ✅ Implement payout request workflow
7. ✅ Add admin revenue analytics dashboard
8. ✅ Configure file storage for production (AWS S3)
9. ✅ Set up monitoring for failed payouts
10. ✅ Create user guide for organizers

## Support

For questions or issues:
- Check logs: `tail -f storage/logs/laravel.log`
- Review database: `php artisan tinker`
- Test in sandbox mode first
- Enable debug mode for detailed errors

---

**Last Updated**: February 2026
**Version**: 1.0.0
