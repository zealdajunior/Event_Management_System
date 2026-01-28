<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Mail\PasswordResetCode as PasswordResetCodeMail;

class PasswordResetController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
        }

        // Generate and save reset code
        $resetCode = PasswordResetCode::createForEmail($request->email);

        // Send email with code
        try {
            Mail::to($request->email)->send(new PasswordResetCodeMail($resetCode->code));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send reset code. Please try again.']);
        }

        return redirect()->route('password.code.form')->with([
            'status' => 'A reset code has been sent to your email address.',
            'email' => $request->email
        ]);
    }

    public function showCodeForm()
    {
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $resetCode = PasswordResetCode::valid()
            ->byEmail($request->email)
            ->byCode($request->code)
            ->first();

        if (!$resetCode) {
            return back()->withErrors(['code' => 'Invalid or expired reset code.']);
        }

        // Store verified email in session for password reset
        session(['password_reset_email' => $request->email]);

        return redirect()->route('password.reset.form');
    }

    public function showResetPasswordForm()
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request');
        }

        // Update password
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        // Clean up reset code
        PasswordResetCode::where('email', $email)->delete();

        // Clear session
        session()->forget('password_reset_email');

        return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
    }
}
