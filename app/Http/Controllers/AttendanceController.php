<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource for an event.
     */
    public function index(Request $request)
    {
        $eventId = $request->get('event_id');
        
        $query = Attendance::with(['user', 'booking', 'event', 'checker']);
        
        if ($eventId) {
            $query->where('event_id', $eventId);
        }
        
        $attendances = $query->latest()->paginate(20);
        $events = Event::all();
        
        return view('attendance.index', compact('attendances', 'events'));
    }

    /**
     * Check-in an attendee using QR code.
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $attendance = Attendance::where('qr_code', $request->qr_code)->first();

        if (!$attendance) {
            return response()->json(['message' => 'Invalid QR code'], 404);
        }

        if ($attendance->status === 'checked_in') {
            return response()->json(['message' => 'Already checked in'], 400);
        }

        $attendance->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Successfully checked in',
            'attendance' => $attendance->load(['user', 'event']),
        ]);
    }

    /**
     * Get attendance record by QR code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $attendance = Attendance::with(['user', 'event', 'booking'])
            ->where('qr_code', $request->qr_code)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Invalid QR code'], 404);
        }

        return response()->json(['attendance' => $attendance]);
    }

    /**
     * Display the check-in scanner interface.
     */
    public function scanner()
    {
        return view('attendance.scanner');
    }

    /**
     * Get attendance statistics for an event.
     */
    public function statistics($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $total = Attendance::where('event_id', $eventId)->count();
        $checkedIn = Attendance::where('event_id', $eventId)
            ->where('status', 'checked_in')
            ->count();
        $pending = Attendance::where('event_id', $eventId)
            ->where('status', 'pending')
            ->count();

        return response()->json([
            'event' => $event,
            'statistics' => [
                'total' => $total,
                'checked_in' => $checkedIn,
                'pending' => $pending,
                'percentage' => $total > 0 ? round(($checkedIn / $total) * 100, 2) : 0,
            ],
        ]);
    }
}
