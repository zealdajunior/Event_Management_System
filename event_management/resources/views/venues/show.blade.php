<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Venue Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">{{ $venue->name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-700">Address</h4>
                                <p class="text-gray-600">{{ $venue->address }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Capacity</h4>
                                <p class="text-gray-600">{{ $venue->capacity }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-start mt-6 space-x-4">
                        <a href="{{ route('venues.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Venues
                        </a>
                        <a href="{{ route('venues.edit', $venue) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Venue
                        </a>
                        <form method="POST" action="{{ route('venues.destroy', $venue) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this venue?')">
                                Delete Venue
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
