<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Celebratory Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-10 left-20 text-6xl animate-bounce" style="animation-delay: 0s">🎉</div>
            <div class="absolute top-40 right-20 text-6xl animate-bounce" style="animation-delay: 0.5s">🎊</div>
            <div class="absolute bottom-20 left-40 text-6xl animate-bounce" style="animation-delay: 1s">✨</div>
            <div class="absolute bottom-40 right-40 text-6xl animate-bounce" style="animation-delay: 1.5s">🎈</div>
            <div class="absolute top-1/2 left-10 text-5xl animate-ping" style="animation-delay: 2s">⭐</div>
            <div class="absolute top-1/3 right-10 text-5xl animate-ping" style="animation-delay: 2.5s">🌟</div>
        </div>

        <div class="max-w-3xl w-full space-y-8 relative z-10">
            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-3 mb-12">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-2xl ring-4 ring-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="w-24 h-2 bg-blue-500 rounded-full shadow-lg"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-2xl ring-4 ring-blue-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="w-24 h-2 bg-blue-500 rounded-full shadow-lg"></div>
                </div>
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-blue-600 font-black text-xl shadow-2xl ring-4 ring-blue-300 transform scale-110 animate-pulse">
                    3
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-white/50 animate-fadeIn">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl mb-6 shadow-2xl animate-bounce">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-blue-600 mb-3">Almost There! 🎉</h2>
                    <p class="text-gray-600 text-lg">Final step - Your event preferences • <span class="text-blue-600 font-semibold">Step 3 of 3</span></p>
                </div>

                <form method="POST" action="{{ route('onboarding.step3.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center gap-2 text-lg font-bold text-gray-700 mb-4">
                                <span class="text-2xl">🎯</span>
                                <span>What type of events do you prefer?</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php
                                    $eventTypes = [
                                        'conferences' => ['label' => 'Conferences & Seminars', 'icon' => '🎓', 'color' => 'blue'],
                                        'concerts' => ['label' => 'Concerts & Music', 'icon' => '🎵', 'color' => 'purple'],
                                        'sports' => ['label' => 'Sports Events', 'icon' => '⚽', 'color' => 'green'],
                                        'workshops' => ['label' => 'Workshops & Training', 'icon' => '🛠️', 'color' => 'orange'],
                                        'networking' => ['label' => 'Networking Events', 'icon' => '🤝', 'color' => 'indigo'],
                                        'festivals' => ['label' => 'Festivals & Fairs', 'icon' => '🎪', 'color' => 'pink']
                                    ];
                                @endphp

                                @foreach($eventTypes as $value => $data)
                                    <label class="relative flex items-center gap-4 p-5 bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-blue-400 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
                                        <input type="radio" name="favorite_event_types" value="{{ $value }}" class="peer hidden" required>
                                        <div class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 peer-checked:animate-bounce">
                                            {{ $data['icon'] }}
                                        </div>
                                        <span class="flex-1 text-gray-700 font-bold group-hover:text-blue-600 peer-checked:text-blue-600 transition-colors">{{ $data['label'] }}</span>
                                        <div class="absolute inset-0 border-4 border-blue-500 bg-blue-50/30 rounded-2xl opacity-0 peer-checked:opacity-100 transition-all duration-300 pointer-events-none"></div>
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500 transition-all duration-300">
                                            <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('favorite_event_types')
                                <p class="mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="transform hover:scale-[1.02] transition-all duration-300">
                            <label for="bio" class="flex items-center gap-2 text-lg font-bold text-gray-700 mb-3">
                                <span class="text-2xl">✍️</span>
                                <span>Tell us about yourself</span>
                                <span class="text-sm font-normal text-gray-500">(optional)</span>
                            </label>
                            <div class="relative group">
                                <textarea id="bio" name="bio" rows="5" placeholder="Share your story, hobbies, or what excites you about events..." maxlength="500"
                                          class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-base resize-none group-hover:border-blue-300"></textarea>
                                <div class="absolute inset-0 -z-10 bg-gradient-to-r from-blue-400 to-blue-500 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition-opacity duration-300"></div>
                                <p class="mt-2 text-sm text-gray-500">✨ Max 500 characters</p>
                            </div>
                            @error('bio')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-8 gap-4">
                        <a href="{{ route('onboarding.step2') }}" class="text-gray-500 hover:text-gray-700 font-semibold transition-colors px-6 py-3 rounded-xl hover:bg-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Back</span>
                        </a>
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-black text-lg py-5 px-12 rounded-2xl shadow-2xl hover:shadow-blue-500/50 transform hover:scale-110 active:scale-95 transition-all duration-300 flex items-center gap-3 animate-pulse">
                            <span>🎉 Complete Setup!</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
