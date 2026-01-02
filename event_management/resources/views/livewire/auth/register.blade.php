<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center 
                bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 
                dark:from-zinc-950 dark:via-indigo-950 dark:to-purple-950 
                px-6 py-12">
        
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white dark:bg-zinc-900 
                        rounded-2xl 
                        shadow-xl 
                        border border-zinc-200 dark:border-zinc-800 
                        p-15">
                
                <!-- Header -->
                <x-auth-header 
                    :title="__('Create an account')" 
                    :description="__('Enter your details below to create your account')" 
                    class="text-center mb-8"
                />

                <!-- Session Status -->
                <x-auth-session-status :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
                    @csrf
                    
                    <!-- Name -->
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        :value="old('name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        :placeholder="__('Full name')"
                    />

                    <!-- Email Address -->
                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        :value="old('email')"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <!-- Password -->
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    <!-- Confirm Password -->
                    <flux:input
                        name="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                    />

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <flux:button 
                            type="submit"
                            variant="primary" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 
                                   hover:from-blue-700 hover:to-indigo-700 
                                   text-white font-semibold 
                                   py-3 rounded-xl 
                                   shadow-lg hover:shadow-xl
                                   transform hover:scale-[1.02]
                                   transition-all duration-200"
                            data-test="register-user-button">
                            {{ __('Create account') }}
                        </flux:button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-zinc-600 dark:text-zinc-400">
                    <span>{{ __('Already have an account?') }}</span>
                    <flux:link 
                        :href="route('login')" 
                        wire:navigate
                        class="ml-1 font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 hover:underline">
                        {{ __('Log in') }}
                    </flux:link>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>