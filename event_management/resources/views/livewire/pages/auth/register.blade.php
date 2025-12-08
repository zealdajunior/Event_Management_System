<div class="max-w-md mx-auto bg-blue shadow-lg rounded-xl p-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">
            Create Your Account
        </h1>
        <p class="text-gray-500 text-sm">
            Join thousands of users managing events effortlessly
        </p>
    </div>

    <!-- Form -->
    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                wire:model="name" 
                id="name" 
                type="text" 
                name="name" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Enter your full name"
                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-blue-700" />
            <x-text-input 
                wire:model="email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autocomplete="username" 
                placeholder="Enter your email address"
                class="mt-2 w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-blue-700" />
            <x-text-input 
                wire:model="password" 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
                placeholder="Create a strong password"
                class="mt-2 w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />
            <x-text-input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                placeholder="Confirm your password"
                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6">
            <a class="text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200" href="{{ route('login') }}" wire:navigate>
                {{ __('Already have an account? Sign in') }}
            </a>

            <x-primary-button class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</div>