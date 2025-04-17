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


        </div>

        <form wire:submit.prevent="bookEvent">



@if($is_still_available)
<button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"

>Confirm Booking</button>




@else

<h1>
    sorry , we are full
</h1>
@endif
        </form>
    @endif
</div>
