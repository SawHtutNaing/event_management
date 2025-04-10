<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Upcoming Events</h1>
        <div class="flex space-x-2">
            <input type="text" wire:model.live="search" placeholder="Search events..." class="px-4 py-2 border rounded">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $event->title }}</h2>
                    <p class="text-gray-600 mb-2">
                        {{ $event->start_date->format('F j, Y g:i A') }} - 
                        {{ $event->end_date->format('g:i A') }}
                    </p>
                    <p class="text-gray-600 mb-2">{{ $event->location }}</p>
                    <p class="text-gray-700 mb-4">{{ Str::limit($event->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">${{ number_format($event->price, 2) }}</span>
                        <a href="{{ route('events.show', $event->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>