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
    }
}
