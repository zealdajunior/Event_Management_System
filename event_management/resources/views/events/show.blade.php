<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">{{ $event->name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-700">Description</h4>
                                <p class="text-gray-600">{{ $event->description ?: 'No description provided.' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Date</h4>
                                <p class="text-gray-600">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y \a\t g:i A') : 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Location</h4>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Venue</h4>
                                <p class="text-gray-600">{{ $event->venue ? $event->venue->name : 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Status</h4>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $event->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Created By</h4>
                                <p class="text-gray-600">{{ $event->user ? $event->user->name : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-start mt-6 space-x-4">
                        <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Events
                        </a>
                        <a href="{{ route('events.edit', $event) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Event
                        </a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this event?')">
                                Delete Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
