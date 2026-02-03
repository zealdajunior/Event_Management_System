<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->validate();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Check if user needs email verification (but don't block super admins)
        $user = Auth::user();
        if ($user && !$user->hasVerifiedEmail() && !($user->is_super_admin ?? false)) {
            // For regular users and admins, send verification notice but don't block login
            // They can still access the dashboard but will see a verification reminder
            session()->flash('verification_reminder', 'Please verify your email address to access all features.');
        }
    }
}
