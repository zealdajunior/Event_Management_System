@props(['event'])

<div class="relative w-full h-48 rounded-xl overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500">
    @if($event->featuredImage)
        <img src="{{ asset('storage/' . $event->featuredImage->file_path) }}" 
             alt="{{ $event->name }}" 
             class="w-full h-full object-cover">
    @elseif($event->images->first())
        <img src="{{ asset('storage/' . $event->images->first()->file_path) }}" 
             alt="{{ $event->name }}" 
             class="w-full h-full object-cover">
    @else
        <!-- Default placeholder -->
        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-600 via-pink-600 to-blue-600">
            <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    @endif
    
    <!-- Media count badge -->
    @if($event->media->count() > 0)
        <div class="absolute bottom-2 right-2 flex gap-2">
            @if($event->images->count() > 0)
                <span class="bg-black/70 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $event->images->count() }}
                </span>
            @endif
            @if($event->videos->count() > 0)
                <span class="bg-black/70 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                    </svg>
                    {{ $event->videos->count() }}
                </span>
            @endif
        </div>
    @endif
    
    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
</div>
