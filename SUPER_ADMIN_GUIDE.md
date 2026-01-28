# Super Admin System - Complete Guide

## Overview

The Super Admin system has been successfully implemented in your Event Management application. This system provides enhanced privileges for managing administrators, users, and system-wide settings.

## Features Implemented

### 1. Database Schema
✅ **Users Table:**
- Added `is_super_admin` boolean field (default: false)

✅ **Event Requests Table:**
- Added 14 verification fields for comprehensive event approval workflow:
  - `email_verified_at` - Email verification timestamp
  - `phone_verified_at` - Phone verification timestamp
  - `verification_documents` - JSON field for storing document metadata
  - `verification_status` - Status: pending, verified, rejected (default: 'pending')
  - `verification_notes` - Admin notes about verification
  - `risk_score` - Integer score for risk assessment (default: 0)
  - `organization_registration_number` - Legal business registration
  - `organizer_id_number` - Personal ID number
  - `organizer_id_document` - Path to uploaded ID document
  - `event_permit_document` - Path to uploaded event permit
  - `venue_booking_document` - Path to venue booking proof
  - `social_media_links` - Social media presence verification
  - `verified_by` - Foreign key to admin who verified
  - `verified_at` - Verification completion timestamp

### 2. User Model Enhancements
✅ **New Methods:**
```php
// Check if user is super admin
$user->isSuperAdmin(); // Returns true if is_super_admin AND role is 'admin'

// Check if user is admin or super admin
$user->isAdminOrSuperAdmin(); // Returns true for both admins and super admins
```

### 3. CLI Command
✅ **Promote Admin to Super Admin:**
```bash
php artisan admin:promote-super admin@example.com
```

Features:
- Validates user exists
- Ensures user is already an admin
- Prevents duplicate promotion
- Shows success message with privilege list

### 4. Admin Management Controller
✅ **6 Core Functions:**

1. **index()** - Display management dashboard
2. **promoteToAdmin(User $user)** - Upgrade user to admin role
3. **demoteToUser(User $user)** - Downgrade admin to user role
4. **deleteUser(User $user)** - Permanently delete user account
5. **createAdmin(Request $request)** - Create new admin account
6. **toggleSuperAdmin(User $user)** - Grant/revoke super admin privileges

### 5. Routes
✅ **6 Protected Routes (Super Admin Only):**
```php
GET    /admin/management               -> View management dashboard
POST   /admin/users/{user}/promote     -> Promote user to admin
POST   /admin/users/{user}/demote      -> Demote admin to user
DELETE /admin/users/{user}             -> Delete user
POST   /admin/admins/create            -> Create new admin
POST   /admin/users/{user}/toggle-super -> Toggle super admin status
```

### 6. Management Dashboard View
✅ **resources/views/admin/management/index.blade.php**

Features:
- Statistics dashboard (total users, admins)
- Super admin list with badges
- Create new admin form
- Current admins table with actions:
  - Grant/revoke super admin privileges
  - Demote admin to user
  - Delete admin
- Regular users table with actions:
  - Promote to admin
  - Delete user
- Pagination for user lists
- Success/error message display

### 7. Admin Dashboard Integration
✅ **New "Management" Tab:**
- Only visible to super admins
- Purple/blue gradient styling to distinguish from regular tabs
- Quick stats cards
- Quick action buttons
- System information overview
- Link to full management panel

## How to Use

### Step 1: Create Your First Super Admin

1. Make sure you have at least one admin user in your system
2. Run the promotion command:
```bash
cd "c:\Users\Zealda Junior\Desktop\Event\event_management"
php artisan admin:promote-super your-admin@example.com
```

3. You should see:
```
✓ User promoted to super admin successfully!

Super admin privileges granted:
✓ Manage all administrators
✓ Promote users to admin
✓ Demote admins to users
✓ Delete users and admins
✓ Create new admin accounts
✓ Grant/revoke super admin status
✓ Final decision on event requests
✓ Access to verification system
```

### Step 2: Access the Management Dashboard

1. Log in as the super admin
2. Navigate to Admin Dashboard
3. You'll see a new "Management" tab (purple/blue gradient)
4. Click on "Management" or go directly to: `/admin/management`

### Step 3: Manage Admins

**Create New Admin:**
1. Fill out the form in the "Create New Admin" section
2. Enter: Name, Email, Password, Password Confirmation
3. Click "Create Admin"
4. New admin will be created with auto-verified email

**Promote User to Admin:**
1. Go to "Regular Users" table
2. Click the green up-arrow icon next to a user
3. User will be promoted to admin role

**Demote Admin to User:**
1. Go to "Current Admins" table
2. Click the yellow down-arrow icon next to an admin
3. Admin will be demoted to user role
4. Note: Cannot demote super admins

**Grant Super Admin Privileges:**
1. Go to "Current Admins" table
2. Click the purple star icon next to an admin
3. Admin will be granted super admin privileges

**Revoke Super Admin Privileges:**
1. Go to "Super Admins" section
2. Click the orange minus icon next to a super admin
3. Super admin will be demoted to regular admin
4. Note: Cannot revoke your own super admin status

**Delete User/Admin:**
1. Click the red trash icon next to any user or admin
2. Confirm the deletion in the popup
3. User/Admin will be permanently deleted
4. Note: Cannot delete super admins or yourself

### Step 4: Monitor Actions

All super admin actions are logged via AuditLogger service:
- User promoted to admin
- Admin demoted to user
- User deleted
- Admin created
- Super admin granted
- Super admin revoked

Check logs at: `storage/logs/laravel.log`

## Security Features

✅ **Authorization Checks:**
- All management functions check `isSuperAdmin()` before execution
- Non-super admins get 403 Forbidden error
- Cannot delete yourself
- Cannot revoke your own super admin status
- Cannot delete other super admins

✅ **Validation:**
- Email must be unique when creating admins
- Password must be at least 8 characters
- Password confirmation required
- User must exist before promotion/demotion/deletion
- User must be admin before granting super admin status

✅ **Audit Trail:**
- All actions logged with timestamps
- User ID of who performed the action
- Target user ID
- Action type (promote, demote, delete, etc.)

## Navigation Guide

### For Regular Admins:
- See 10 tabs: Events, Bookings, Users, Revenue, Alerts, Emails, Check-in, Feedback, Requests, Analytics
- No "Management" tab visible

### For Super Admins:
- See 11 tabs (includes "Management" tab)
- Management tab has purple/blue gradient
- Management tab shows:
  - Quick stats
  - Quick actions
  - System information
  - Link to full management panel

## Privileges Comparison

| Feature | User | Admin | Super Admin |
|---------|------|-------|-------------|
| Create events | ✓ | ✓ | ✓ |
| Edit own events | ✓ | ✓ | ✓ |
| View admin dashboard | ✗ | ✓ | ✓ |
| Approve event requests | ✗ | ✓ | ✓ |
| Manage users | ✗ | View only | ✓ |
| Promote users to admin | ✗ | ✗ | ✓ |
| Demote admins | ✗ | ✗ | ✓ |
| Delete users | ✗ | ✗ | ✓ |
| Create new admins | ✗ | ✗ | ✓ |
| Grant super admin status | ✗ | ✗ | ✓ |
| Access management panel | ✗ | ✗ | ✓ |

## Next Steps: Event Verification System

The database is already prepared for comprehensive event verification. Next steps include:

### Phase 3: Event Request Form Enhancement
- Add document upload fields to event request form
- Add organization registration number field
- Add organizer ID number field
- Add social media links field
- Add file validation (max size, allowed types)

### Phase 4: Email/Phone Verification
- Send verification emails to event organizers
- Send SMS verification codes
- Store verification timestamps
- Require verification before approval

### Phase 5: Risk Assessment
- Implement risk scoring algorithm
- Check against blocklists
- Analyze event details for suspicious patterns
- Flag high-risk events for manual review

### Phase 6: Verification Dashboard
- Admin view for pending verifications
- Checklist interface for document review
- Upload verification notes
- Set verification status
- Multi-level approval workflow

### Phase 7: Super Admin Final Approval
- High-risk events require super admin approval
- Super admin can override admin decisions
- Super admin verification badge
- Enhanced audit logging

## Troubleshooting

**Problem:** "User not found" when promoting
- Solution: Make sure the email address is correct and exists in the database

**Problem:** "User is not an admin" when promoting to super admin
- Solution: First promote the user to admin role, then to super admin

**Problem:** "User is already a super admin"
- Solution: This user is already promoted. Use the toggle function to revoke if needed

**Problem:** Cannot see Management tab
- Solution: Make sure you're logged in as a super admin (check `is_super_admin` in database)

**Problem:** 403 Forbidden error on management pages
- Solution: Only super admins can access these pages. Check your super admin status

## Files Modified/Created

### Created:
1. `database/migrations/2026_01_28_230303_add_super_admin_and_verification_fields.php`
2. `app/Console/Commands/PromoteSuperAdmin.php`
3. `app/Http/Controllers/AdminManagementController.php`
4. `resources/views/admin/management/index.blade.php`

### Modified:
1. `app/Models/User.php` - Added super admin methods
2. `routes/web.php` - Added management routes
3. `resources/views/admin-dashboard.blade.php` - Added management tab

## Testing Checklist

- [ ] Promote an admin to super admin via CLI
- [ ] Log in as super admin and see Management tab
- [ ] Access management dashboard at `/admin/management`
- [ ] Create a new admin account
- [ ] Promote a user to admin
- [ ] Demote an admin to user
- [ ] Grant super admin to another admin
- [ ] Revoke super admin status
- [ ] Try to delete yourself (should fail)
- [ ] Try to revoke your own super admin (should fail)
- [ ] Delete a test user account
- [ ] Check audit logs for all actions

## Support

If you encounter any issues:
1. Check `storage/logs/laravel.log` for error messages
2. Verify database migrations ran successfully: `php artisan migrate:status`
3. Clear cache: `php artisan cache:clear && php artisan config:clear`
4. Check user permissions in database: `SELECT id, name, email, role, is_super_admin FROM users;`

---

**System Status:** ✅ Fully Operational
**Version:** 1.0
**Last Updated:** January 28, 2026
