<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <div class="max-w-5xl w-full space-y-8 relative z-10">
            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-3 mb-12">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-2xl ring-4 ring-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="w-24 h-2 bg-blue-500 rounded-full shadow-lg"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-blue-600 font-black text-xl shadow-2xl ring-4 ring-blue-300 transform scale-110 animate-pulse">
                        2
                    </div>
                    <div class="w-24 h-2 bg-blue-200 rounded-full"></div>
                </div>
                <div class="w-14 h-14 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-400 font-bold text-xl shadow-lg">3</div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-blue-100 animate-fadeIn">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl mb-6 shadow-2xl transform hover:rotate-12 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-blue-600 mb-3">What Do You Love?</h2>
                    <p class="text-gray-600 text-lg">Pick all your interests • <span class="text-blue-600 font-semibold">Step 2 of 3</span></p>
                </div>

                <form method="POST" action="{{ route('onboarding.step2.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @php
                            $interests = [
                                'Music' => ['emoji' => '🎵', 'color' => 'purple'],
                                'Technology' => ['emoji' => '💻', 'color' => 'blue'],
                                'Sports' => ['emoji' => '⚽', 'color' => 'green'],
                                'Art' => ['emoji' => '🎨', 'color' => 'pink'],
                                'Food' => ['emoji' => '🍕', 'color' => 'orange'],
                                'Travel' => ['emoji' => '✈️', 'color' => 'cyan'],
                                'Business' => ['emoji' => '💼', 'color' => 'indigo'],
                                'Health' => ['emoji' => '🏥', 'color' => 'red'],
                                'Education' => ['emoji' => '📚', 'color' => 'yellow'],
                                'Entertainment' => ['emoji' => '🎭', 'color' => 'fuchsia'],
                                'Gaming' => ['emoji' => '🎮', 'color' => 'violet'],
                                'Fashion' => ['emoji' => '👔', 'color' => 'rose']
                            ];
                        @endphp

                        @foreach($interests as $interest => $data)
                            <label class="relative flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-3xl cursor-pointer hover:border-blue-400 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
                                <input type="checkbox" name="interests[]" value="{{ $interest }}" class="peer hidden">
                                <div class="text-5xl mb-3 transform group-hover:scale-125 group-hover:rotate-12 transition-all duration-300 peer-checked:animate-bounce">{{ $data['emoji'] }}</div>
                                <span class="text-sm font-bold text-gray-700 peer-checked:text-{{ $data['color'] }}-600 transition-colors">{{ $interest }}</span>
                                
                                <!-- Selected State -->
                                <div class="absolute inset-0 border-4 border-{{ $data['color'] }}-500 bg-{{ $data['color'] }}-50/50 rounded-3xl opacity-0 peer-checked:opacity-100 transition-all duration-300 pointer-events-none shadow-lg"></div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-gradient-to-br from-{{ $data['color'] }}-500 to-{{ $data['color'] }}-600 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-all duration-300 shadow-2xl transform peer-checked:scale-110 peer-checked:rotate-12">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('interests')
                        <p class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="flex items-center justify-between pt-8 gap-4">
                        <a href="{{ route('onboarding.step1') }}" class="text-gray-500 hover:text-gray-700 font-semibold transition-colors px-6 py-3 rounded-xl hover:bg-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Back</span>
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
</x-app-layout>
