<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Event Calendar</h1>
        <div class="flex space-x-2">
            <button wire:click="goToToday" class="px-4 py-2 bg-gray-200 rounded">Today</button>
            <button wire:click="previousPeriod" class="px-4 py-2 bg-gray-200 rounded">&lt;</button>
            <button wire:click="nextPeriod" class="px-4 py-2 bg-gray-200 rounded">&gt;</button>
            <span class="px-4 py-2 font-semibold">
                @if($view === 'month')
                    {{ $currentDate->format('F Y') }}
                @elseif($view === 'week')
                    Week {{ $currentDate->weekOfYear }}, {{ $currentDate->format('Y') }}
                @else
                    {{ $currentDate->format('l, F j, Y') }}
                @endif
            </span>
            <select wire:model.live="view" class="px-4 py-2 border rounded">
                <option value="month">Month</option>
                <option value="week">Week</option>
                <option value="day">Day</option>
            </select>
        </div>
    </div>

    @if($view === 'month')
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="bg-gray-100 py-2 text-center font-semibold">{{ $day }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @php
                    $firstDayOfMonth = $currentDate->copy()->startOfMonth();
                    $lastDayOfMonth = $currentDate->copy()->endOfMonth();
                    $startDay = $firstDayOfMonth->copy()->startOfWeek();
                    $endDay = $lastDayOfMonth->copy()->endOfWeek();
                    $currentDay = $startDay->copy();
                @endphp

                @while($currentDay <= $endDay)
                    <div class="bg-white min-h-24 p-1 @if(!$currentDay->isSameMonth($currentDate)) bg-gray-50 @endif">
                        <div class="text-right @if($currentDay->isToday()) bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center float-right @endif">
                            {{ $currentDay->day }}
                        </div>
                        <div class="mt-6 space-y-1">
                            @foreach($events as $event)
                                @if($currentDay->between($event->start_date, $event->end_date))
                                    <div wire:click="showEvent({{ $event->id }})" 
                                         class="text-xs p-1 rounded bg-blue-100 text-blue-800 cursor-pointer truncate">
                                        {{ $event->title }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @php $currentDay->addDay(); @endphp
                @endwhile
            </div>
        </div>
    @elseif($view === 'week')
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @php
                    $startOfWeek = $currentDate->copy()->startOfWeek();
                    $endOfWeek = $currentDate->copy()->endOfWeek();
                    $currentDay = $startOfWeek->copy();
                @endphp

                @for($i = 0; $i < 7; $i++)
                    <div class="bg-gray-100 py-2 text-center font-semibold">
                        {{ $currentDay->format('D') }}<br>
                        {{ $currentDay->format('j') }}
                    </div>
                    @php $currentDay->addDay(); @endphp
                @endfor
            </div>
            <div class="grid grid-cols-7 gap-px bg-gray-200 min-h-96">
                @php $currentDay = $startOfWeek->copy(); @endphp
                @for($i = 0; $i < 7; $i++)
                    <div class="bg-white p-1">
                        <div class="space-y-1">
                            @foreach($events as $event)
                                @if($currentDay->between($event->start_date, $event->end_date))
                                    <div wire:click="showEvent({{ $event->id }})" 
                                         class="text-xs p-1 rounded bg-blue-100 text-blue-800 cursor-pointer truncate">
                                        {{ $event->title }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @php $currentDay->addDay(); @endphp
                @endfor
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold">{{ $currentDate->format('l, F j, Y') }}</h2>
            </div>
            <div class="divide-y">
                @php
                    $dayEvents = $events->filter(function($event) {
                        return $this->currentDate->between($event->start_date, $event->end_date);
                    });
                @endphp

                @if($dayEvents->isEmpty())
                    <div class="p-4 text-center text-gray-500">No events scheduled for this day</div>
                @else
                    @foreach($dayEvents as $event)
                        <div class="p-4 hover:bg-gray-50 cursor-pointer" wire:click="showEvent({{ $event->id }})">
                            <h3 class="font-semibold">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}
                            </p>
                            <p class="text-sm">{{ $event->location }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    <!-- Event Modal -->
    @if($showEventModal && $selectedEvent)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-semibold">{{ $selectedEvent->title }}</h2>
                    <button wire:click="$set('showEventModal', false)" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>
                <div class="p-4">
                    <p class="mb-2"><span class="font-semibold">Date:</span> {{ $selectedEvent->start_date->format('F j, Y') }}</p>
                    <p class="mb-2"><span class="font-semibold">Time:</span> {{ $selectedEvent->start_date->format('g:i A') }} - {{ $selectedEvent->end_date->format('g:i A') }}</p>
                    <p class="mb-2"><span class="font-semibold">Location:</span> {{ $selectedEvent->location }}</p>
                    <p class="mb-2"><span class="font-semibold">Price:</span> ${{ number_format($selectedEvent->price, 2) }}</p>
                    <p class="mb-4"><span class="font-semibold">Available Tickets:</span> {{ $selectedEvent->availableTickets() }}</p>
                    <p>{{ $selectedEvent->description }}</p>
                </div>
                <div class="p-4 border-t flex justify-end space-x-2">
                    <button wire:click="$set('showEventModal', false)" class="px-4 py-2 bg-gray-200 rounded">Close</button>
                    @auth
                        <a href="{{ route('events.show', $selectedEvent->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Book Now</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Login to Book</a>
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>