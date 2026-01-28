<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-3xl w-full space-y-8 relative z-10">
            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-3 mb-12">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-blue-600 font-black text-xl shadow-2xl ring-4 ring-blue-300 transform scale-110 animate-pulse">
                        1
                    </div>
                    <div class="w-24 h-2 bg-blue-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-400 font-bold text-xl shadow-lg">2</div>
                    <div class="w-24 h-2 bg-blue-100 rounded-full"></div>
                </div>
                <div class="w-14 h-14 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-400 font-bold text-xl shadow-lg">3</div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-blue-100 animate-fadeIn">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl mb-6 shadow-2xl transform hover:rotate-12 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-blue-600 mb-3">Welcome! Let's Get Started</h2>
                    <p class="text-gray-600 text-lg">Tell us a bit about yourself • <span class="text-blue-600 font-semibold">Step 1 of 3</span></p>
                </div>

                <form method="POST" action="{{ route('onboarding.step1.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-6">
                        <div class="transform hover:scale-[1.02] transition-all duration-300">
                            <label for="location" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                <span class="text-2xl">📍</span>
                                <span>Where are you from?</span>
                            </label>
                            <div class="relative group">
                                <input id="location" name="location" type="text" placeholder="e.g., New York, USA"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-lg group-hover:border-blue-300">
                                <div class="absolute inset-0 -z-10 bg-blue-400 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                            </div>
                            @error('location')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="transform hover:scale-[1.02] transition-all duration-300">
                            <label for="date_of_birth" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                <span class="text-2xl">🎂</span>
                                <span>When's your birthday?</span>
                            </label>
                            <div class="relative group">
                                <input id="date_of_birth" name="date_of_birth" type="date"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-lg group-hover:border-blue-300">
                                <div class="absolute inset-0 -z-10 bg-blue-400 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                            </div>
                            @error('date_of_birth')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="transform hover:scale-[1.02] transition-all duration-300">
                            <label for="occupation" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                <span class="text-2xl">💼</span>
                                <span>What do you do?</span>
                            </label>
                            <div class="relative group">
                                <input id="occupation" name="occupation" type="text" placeholder="e.g., Software Engineer, Student, Designer"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-lg group-hover:border-blue-300">
                                <div class="absolute inset-0 -z-10 bg-blue-400 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                            </div>
                            @error('occupation')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-8 gap-4">
                        <a href="{{ route('onboarding.skip') }}" class="text-gray-500 hover:text-gray-700 font-semibold transition-colors px-6 py-3 rounded-xl hover:bg-gray-100">
                            ⏭️ Skip for now
                        </a>
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-10 rounded-2xl shadow-2xl hover:shadow-blue-500/50 transform hover:scale-105 active:scale-95 transition-all duration-300 flex items-center gap-3">
                            <span>Continue</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</x-app-layout>
