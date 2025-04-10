<div class="bg-white rounded-lg shadow p-6">
    @if($bookingSuccess)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p>Your booking has been confirmed! Thank you.</p>
        </div>
        <a href="{{ route('events.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Back to Events</a>
    @else
        <h2 class="text-xl font-semibold mb-4">Book Event: {{ $event->title }}</h2>
        
        <div class="mb-4">
            <p class="text-gray-600">Date: {{ $event->start_date->format('F j, Y') }}</p>
            <p class="text-gray-600">Time: {{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}</p>
            <p class="text-gray-600">Location: {{ $event->location }}</p>
            <p class="text-gray-600">Available Tickets: {{ $event->availableTickets() }}</p>
            <p class="text-gray-600">Price per ticket: ${{ number_format($event->price, 2) }}</p>
        </div>

        <form wire:submit.prevent="bookEvent">
            <div class="mb-4">
                <label for="tickets" class="block text-sm font-medium text-gray-700">Number of Tickets</label>
                <input type="number" wire:model="tickets" wire:change="calculateTotal" min="1" max="{{ $event->availableTickets() }}" id="tickets" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('tickets') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4 p-4 bg-gray-50 rounded">
                <h3 class="font-medium">Order Summary</h3>
                <div class="flex justify-between mt-2">
                    <span>Tickets ({{ $tickets }} × ${{ number_format($event->price, 2) }})</span>
                    <span>${{ number_format($tickets * $event->price, 2) }}</span>
                </div>
                <div class="flex justify-between mt-2 font-semibold">
                    <span>Total</span>
                    <span>${{ number_format($tickets * $event->price, 2) }}</span>
                </div>
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Confirm Booking</button>
        </form>
    @endif
</div>