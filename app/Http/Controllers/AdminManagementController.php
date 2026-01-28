<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditLogger;

class AdminManagementController extends Controller
{
    /**
     * Display admin management dashboard (Super Admin only)
     */
    public function index()
    {
        // Check if user is super admin
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Only Super Admins can access this page.');
        }

        $admins = User::where('role', 'admin')->latest()->get();
        $regularUsers = User::where('role', 'user')->latest()->paginate(20);
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $superAdmins = User::where('is_super_admin', true)->get();

        return view('admin.management.index', compact(
            'admins',
            'regularUsers',
            'totalUsers',
            'totalAdmins',
            'superAdmins'
        ));
    }

    /**
     * Promote a user to admin
     */
    public function promoteToAdmin(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can promote users to admin.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'User is already an admin.');
        }

        $user->role = 'admin';
        $user->save();

        AuditLogger::log('promoted_to_admin', 'User', $user->id, [
            'user_name' => $user->name,
            'promoted_by' => auth()->user()->name
        ]);

        return back()->with('status', "{$user->name} has been promoted to Admin.");
    }

    /**
     * Demote an admin to regular user
     */
    public function demoteToUser(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can demote admins.');
        }

        if ($user->is_super_admin) {
            return back()->with('error', 'Cannot demote a Super Admin. Remove super admin status first.');
        }

        if ($user->role !== 'admin') {
            return back()->with('error', 'User is not an admin.');
        }

        $user->role = 'user';
        $user->save();

        AuditLogger::log('demoted_to_user', 'User', $user->id, [
            'user_name' => $user->name,
            'demoted_by' => auth()->user()->name
        ]);

        return back()->with('status', "{$user->name} has been demoted to regular user.");
    }

    /**
     * Delete a user (Super Admin only)
     */
    public function deleteUser(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can delete users.');
        }

        if ($user->is_super_admin) {
            return back()->with('error', 'Cannot delete a Super Admin.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $userName = $user->name;
        
        AuditLogger::log('deleted_user', 'User', $user->id, [
            'user_name' => $userName,
            'user_email' => $user->email,
            'deleted_by' => auth()->user()->name
        ]);

        $user->delete();

        return back()->with('status', "User {$userName} has been permanently deleted.");
    }

    /**
     * Create a new admin (Super Admin only)
     */
    public function createAdmin(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can create admin accounts.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'email_verified_at' => now(), // Auto-verify admin emails
        ]);

        AuditLogger::log('created_admin', 'User', $admin->id, [
            'admin_name' => $admin->name,
            'created_by' => auth()->user()->name
        ]);

        return back()->with('status', "Admin account created for {$admin->name}.");
    }

    /**
     * Toggle super admin status (Super Admin only)
     */
    public function toggleSuperAdmin(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can manage super admin privileges.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot modify your own super admin status.');
        }

        if ($user->role !== 'admin') {
            return back()->with('error', 'User must be an admin first.');
        }

        $user->is_super_admin = !$user->is_super_admin;
        $user->save();

        $action = $user->is_super_admin ? 'granted' : 'revoked';
        
        AuditLogger::log("{$action}_super_admin", 'User', $user->id, [
            'user_name' => $user->name,
            'action_by' => auth()->user()->name
        ]);

        $message = $user->is_super_admin 
            ? "{$user->name} is now a Super Admin." 
            : "Super Admin privileges revoked from {$user->name}.";

        return back()->with('status', $message);
    }
}
