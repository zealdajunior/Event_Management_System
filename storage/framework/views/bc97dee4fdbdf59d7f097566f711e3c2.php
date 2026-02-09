<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-12 border border-gray-100">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Verify Your Email</h1>
                <p class="text-gray-600">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status') == 'verification-link-sent'): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-700 font-medium">A new verification link has been sent to your email address!</p>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="space-y-4">
                <button wire:click="sendVerification" type="button" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 px-6 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    Resend Verification Email
                </button>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <button wire:click="logout" type="button" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-bold transition-colors">
                    Log Out
                </button>
            </div>

            <!-- Help Text -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-xs text-blue-700">
                        <p class="font-semibold mb-1">Didn't receive the email?</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Check your spam/junk folder</li>
                            <li>Make sure <?php echo e(config('mail.from.address')); ?> is not blocked</li>
                            <li>Click "Resend Verification Email" above to get a new link</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views\livewire/pages/auth/verify-email.blade.php ENDPATH**/ ?>