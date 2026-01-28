# Activity Audit Log System Documentation

## Overview
The admin dashboard now includes a comprehensive audit logging system that tracks and displays all important admin actions in the Event Management System. This provides accountability and transparency for administrative operations.

## Features Implemented

### 1. **Audit Logging Service**
**Location:** `app/Services/AuditLogger.php`

**Purpose:** Centralized service class for logging admin actions with a standardized format.

**Key Methods:**
- `log($action, $resourceType, $resourceId, $additionalData)` - Log an admin action
- `getRecentLogs($limit)` - Retrieve recent audit logs from file
- `parseLine($line)` - Parse log entries into structured data
- `getActionBadgeColor($action)` - Get color coding for different actions
- `getActionIcon($action)` - Get SVG icons for different actions

**Log Format:**
```
[2026-01-28 10:30:45] local.INFO: [AUDIT] User: Admin Name (ID: 1) | Action: CREATED | Resource: Event (ID: 5) | Details: {"name":"Tech Conference","date":"2026-02-15"}
```

---

### 2. **Audit Log Channel**
**Location:** `config/logging.php`

A dedicated logging channel that writes to `storage/logs/audit.log`:
```php
'audit' => [
    'driver' => 'single',
    'path' => storage_path('logs/audit.log'),
    'level' => 'info',
    'replace_placeholders' => true,
],
```

**Benefits:**
- Separate audit logs from application logs
- Easy to search and filter
- Persistent storage for compliance

---

### 3. **Audit Log Viewer**
**Location:** Admin Dashboard → Analytics Tab → Audit Log Section (bottom of page)

**Features:**
- **Table Display:** Shows last 30 audit entries
- **Color-Coded Actions:** Different colors for create, update, delete, approve, reject, etc.
- **User Information:** Displays who performed each action
- **Resource Details:** Shows what was affected (Event, EventRequest, User, etc.)
- **Timestamps:** Accurate time tracking for all actions
- **Refresh Button:** Reload to see latest logs
- **Responsive Design:** Works on all screen sizes

**Action Color Coding:**
- 🟢 **Green** - CREATED, APPROVED (successful/positive actions)
- 🔵 **Blue** - UPDATED (modification actions)
- 🔴 **Red** - DELETED (removal actions)
- 🟠 **Orange** - REJECTED (denial actions)
- 🟣 **Purple** - SENT (communication actions)
- 🔵 **Teal** - VERIFIED (validation actions)
- ⚪ **Gray** - Other/Unknown

---

## Tracked Admin Actions

### Event Management
| Action | Trigger | Logged Information |
|--------|---------|-------------------|
| **CREATED** | New event created | Event ID, name, date, venue |
| **UPDATED** | Event details modified | Event ID, name, status |
| **DELETED** | Event removed | Event ID, name, date |

### Event Request Processing
| Action | Trigger | Logged Information |
|--------|---------|-------------------|
| **APPROVED** | Event request approved | Request ID, event ID created, event title, requester |
| **REJECTED** | Event request denied | Request ID, rejection reason, requester |

### Communication
| Action | Trigger | Logged Information |
|--------|---------|-------------------|
| **SENT** | Bulk email dispatched | Recipient type, subject, recipient count |

---

## Integration Points

### Controllers with Audit Logging:

1. **EventRequestController**
   - `approve()` - Logs when event request is approved
   - `reject()` - Logs when event request is rejected

2. **EventController**
   - `store()` - Logs new event creation
   - `update()` - Logs event modifications
   - `destroy()` - Logs event deletion

3. **AdminDashboardController**
   - `sendBulkEmail()` - Logs bulk email campaigns

### Usage Example:
```php
use App\Services\AuditLogger;

// After performing an admin action
AuditLogger::log('created', 'Event', $event->id, [
    'name' => $event->name,
    'date' => $event->date,
    'venue' => $event->venue->name
]);
```

---

## How It Works

### 1. Action Performed
Admin performs an action (e.g., creates an event)

### 2. Logging
`AuditLogger::log()` is called with:
- Action type (created, updated, deleted, etc.)
- Resource type (Event, EventRequest, User, etc.)
- Resource ID
- Additional context data (JSON)

### 3. Storage
Log entry is written to `storage/logs/audit.log` with:
- Timestamp
- Environment level
- User information
- Action details
- Resource information

### 4. Display
Admin dashboard reads the log file, parses entries, and displays them in a formatted table with:
- Color-coded badges
- Action icons
- User avatars
- Searchable/filterable data

---

## Security & Compliance

### Access Control
- **Admin Only:** Audit logs are only accessible to users with admin role
- **Protected Route:** Audit log viewer is behind admin middleware
- **No Tampering:** Logs are append-only text files

### Data Retention
- **Log Rotation:** Laravel's daily log rotation can be configured
- **Backup Ready:** Log files can be backed up to cloud storage
- **Compliance:** Meets basic audit trail requirements

### Privacy
- **User IDs:** Links actions to specific admin users
- **IP Tracking:** Can be extended to include IP addresses
- **Sensitive Data:** Additional data is JSON-encoded, can be encrypted

---

## Usage Instructions

### For Admins:

#### Viewing Audit Logs
1. Navigate to Admin Dashboard
2. Click on the **Analytics** tab
3. Scroll to the bottom to see **Activity Audit Log** section
4. Review recent admin actions in the table
5. Click **Refresh** button to see latest entries

#### Understanding Log Entries
Each log entry shows:
- **Timestamp:** When the action occurred
- **User:** Who performed the action (name and ID)
- **Action:** What type of action (color-coded badge)
- **Resource:** What was affected (type and ID)
- **Details:** Additional context (JSON data)

---

## Technical Details

### File Structure:
```
app/
  Services/
    AuditLogger.php          # Main audit logging service
config/
  logging.php                # Log channel configuration
storage/
  logs/
    audit.log                # Audit log file (created automatically)
resources/
  views/
    admin-dashboard.blade.php # Audit log viewer UI
app/
  Http/
    Controllers/
      EventController.php           # Integrated logging
      EventRequestController.php    # Integrated logging
      AdminDashboardController.php  # Integrated logging
```

### Log File Location:
```
storage/logs/audit.log
```

### Log Entry Format:
```
[TIMESTAMP] LEVEL: [AUDIT] User: NAME (ID: X) | Action: ACTION | Resource: TYPE (ID: Y) | Details: JSON
```

---

## Extending the System

### Adding New Actions to Track

1. **Import AuditLogger** in your controller:
```php
use App\Services\AuditLogger;
```

2. **Call log method** after action:
```php
AuditLogger::log('action_type', 'ResourceType', $resourceId, [
    'key' => 'value',
    'additional' => 'context'
]);
```

### Custom Action Types

Edit `AuditLogger::getActionBadgeColor()` and `AuditLogger::getActionIcon()` to add new action types:

```php
public static function getActionBadgeColor(string $action): string
{
    return match(strtoupper($action)) {
        'CREATED' => 'green',
        'YOUR_ACTION' => 'your_color',
        // ... more actions
        default => 'gray',
    };
}
```

### Exporting Audit Logs

To export audit logs to CSV:

```php
// Add to AdminDashboardController
public function exportAuditLog()
{
    $logs = AuditLogger::getRecentLogs(1000);
    
    $filename = 'audit-log-export-' . date('Y-m-d') . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function() use ($logs) {
        $file = fopen('php://output', 'w');
        
        fputcsv($file, ['Timestamp', 'User', 'User ID', 'Action', 'Resource Type', 'Resource ID', 'Details']);
        
        foreach ($logs as $log) {
            fputcsv($file, [
                $log['timestamp'],
                $log['user_name'],
                $log['user_id'],
                $log['action'],
                $log['resource_type'],
                $log['resource_id'],
                $log['details'],
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
```

---

## Troubleshooting

### Issue: Audit logs not appearing
**Solution:** 
1. Check if `storage/logs/audit.log` exists and is writable
2. Verify admin has performed tracked actions
3. Clear config cache: `php artisan config:clear`

### Issue: "Permission denied" error
**Solution:**
```bash
chmod 775 storage/logs
chmod 664 storage/logs/audit.log
```

### Issue: Logs not showing recent actions
**Solution:** Click the **Refresh** button or reload the page. Logs are read from file on page load.

### Issue: Too many logs causing performance issues
**Solution:** Implement log rotation or pagination:
```php
// In AuditLogger::getRecentLogs()
// Only read last N lines instead of entire file
```

---

## Future Enhancements

### Potential Phase 2 Features:

1. **Advanced Filtering:**
   - Filter by date range
   - Filter by user
   - Filter by action type
   - Filter by resource type

2. **Search Functionality:**
   - Full-text search in audit logs
   - Regex pattern matching
   - Case-insensitive search

3. **Export Options:**
   - Export to CSV
   - Export to PDF
   - Export to JSON
   - Email reports

4. **Visualization:**
   - Activity timeline chart
   - Action type distribution pie chart
   - User activity heatmap
   - Peak activity hours graph

5. **Alerting:**
   - Email notifications for critical actions
   - Slack webhook integration
   - SMS alerts for specific events
   - Real-time dashboard updates

6. **Database Storage:**
   - Store logs in database table
   - Enable complex queries
   - Better performance for large datasets
   - Indexed searches

---

## Commit Information

**Commit Hash:** 859c7b2  
**Commit Message:** "Add Activity Audit Log system - Track and display admin actions (approve/reject requests, create/update/delete events, send bulk emails)"  
**Date:** January 28, 2026  
**Branch:** main

---

## Related Files

### Created Files:
1. `app/Services/AuditLogger.php` - Core audit logging service

### Modified Files:
1. `config/logging.php` - Added audit channel configuration
2. `resources/views/admin-dashboard.blade.php` - Added audit log viewer UI
3. `app/Http/Controllers/EventRequestController.php` - Added logging to approve/reject
4. `app/Http/Controllers/EventController.php` - Added logging to create/update/delete
5. `app/Http/Controllers/AdminDashboardController.php` - Added logging to bulk email

---

## Testing Checklist

- [x] AuditLogger service created and configured
- [x] Audit log channel registered in config
- [x] Audit log viewer added to Analytics tab
- [x] Event creation logs action
- [x] Event update logs action
- [x] Event deletion logs action
- [x] Event request approval logs action
- [x] Event request rejection logs action
- [x] Bulk email logs action with recipient count
- [x] Log entries parse correctly
- [x] Color-coded badges display properly
- [x] Action icons render correctly
- [x] Timestamps format correctly
- [x] User information displays accurately
- [x] Refresh button works
- [x] Responsive design on mobile
- [x] Code committed to Git
- [x] Changes pushed to GitHub

---

## Support

For issues or questions about the audit log system:
1. Check log file permissions: `storage/logs/audit.log`
2. Verify audit channel in config: `config/logging.php`
3. Review this documentation
4. Check Laravel logs: `storage/logs/laravel.log`

---

**Status:** ✅ Feature Complete and Deployed

The audit logging system is now fully operational and tracking all key admin actions in your Event Management System!
