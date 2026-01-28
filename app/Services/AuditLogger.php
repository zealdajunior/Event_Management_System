<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    /**
     * Log an admin action to the audit log
     *
     * @param string $action The action performed (e.g., 'created', 'updated', 'deleted')
     * @param string $resourceType The type of resource (e.g., 'Event', 'User', 'EventRequest')
     * @param int|string $resourceId The ID of the resource
     * @param array $additionalData Any additional context data
     * @return void
     */
    public static function log(string $action, string $resourceType, $resourceId, array $additionalData = []): void
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        $logMessage = sprintf(
            '[AUDIT] User: %s (ID: %d) | Action: %s | Resource: %s (ID: %s)',
            $user->name,
            $user->id,
            strtoupper($action),
            $resourceType,
            $resourceId
        );

        if (!empty($additionalData)) {
            $logMessage .= ' | Details: ' . json_encode($additionalData);
        }

        Log::channel('audit')->info($logMessage);
    }

    /**
     * Get recent audit logs
     *
     * @param int $limit Number of logs to retrieve
     * @return array
     */
    public static function getRecentLogs(int $limit = 50): array
    {
        $auditLogPath = storage_path('logs/audit.log');
        
        if (!file_exists($auditLogPath)) {
            return [];
        }

        $lines = file($auditLogPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if (!$lines) {
            return [];
        }

        // Get the last N lines
        $recentLines = array_slice($lines, -$limit);
        $recentLines = array_reverse($recentLines);

        $parsedLogs = [];

        foreach ($recentLines as $line) {
            $parsed = self::parseLine($line);
            if ($parsed) {
                $parsedLogs[] = $parsed;
            }
        }

        return $parsedLogs;
    }

    /**
     * Parse a log line into structured data
     *
     * @param string $line
     * @return array|null
     */
    private static function parseLine(string $line): ?array
    {
        // Example format: [2026-01-28 10:30:45] local.INFO: [AUDIT] User: Admin (ID: 1) | Action: CREATED | Resource: Event (ID: 5)
        
        if (!str_contains($line, '[AUDIT]')) {
            return null;
        }

        // Extract timestamp
        preg_match('/\[(.*?)\]/', $line, $timestampMatch);
        $timestamp = $timestampMatch[1] ?? 'Unknown';

        // Extract user info
        preg_match('/User: (.*?) \(ID: (\d+)\)/', $line, $userMatch);
        $userName = $userMatch[1] ?? 'Unknown';
        $userId = $userMatch[2] ?? '0';

        // Extract action
        preg_match('/Action: (\w+)/', $line, $actionMatch);
        $action = $actionMatch[1] ?? 'UNKNOWN';

        // Extract resource
        preg_match('/Resource: (.*?) \(ID: (.*?)\)/', $line, $resourceMatch);
        $resourceType = $resourceMatch[1] ?? 'Unknown';
        $resourceId = $resourceMatch[2] ?? '0';

        // Extract details if present
        $details = null;
        if (preg_match('/Details: (.*)/', $line, $detailsMatch)) {
            $details = $detailsMatch[1];
        }

        return [
            'timestamp' => $timestamp,
            'user_name' => $userName,
            'user_id' => $userId,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'details' => $details,
        ];
    }

    /**
     * Get action badge color based on action type
     *
     * @param string $action
     * @return string
     */
    public static function getActionBadgeColor(string $action): string
    {
        return match(strtoupper($action)) {
            'CREATED' => 'green',
            'UPDATED' => 'blue',
            'DELETED' => 'red',
            'APPROVED' => 'green',
            'REJECTED' => 'orange',
            'SENT' => 'purple',
            'VERIFIED' => 'teal',
            default => 'gray',
        };
    }

    /**
     * Get action icon based on action type
     *
     * @param string $action
     * @return string SVG path
     */
    public static function getActionIcon(string $action): string
    {
        return match(strtoupper($action)) {
            'CREATED' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
            'UPDATED' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'DELETED' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'APPROVED' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'REJECTED' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            'SENT' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    }
}
