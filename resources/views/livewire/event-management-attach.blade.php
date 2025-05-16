<div class="p-6 max-w-4xl mx-auto bg-white rounded-xl shadow">
    <h2 class="text-3xl font-bold mb-6 text-gray-800"> Event & Batch Management</h2>

    {{-- Select Event --}}
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-2">Select Event:</label>
        <select wire:change="selectEvent($event.target.value)" class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <option value="">-- Choose an Event --</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>
    </div>

    {{-- Attach Batch to Event --}}
    @if($selectedEvent)
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Attach Batch to <span class="text-blue-600">{{ $selectedEvent->title }}</span>:</label>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center sm:space-x-3 space-y-2 sm:space-y-0 mt-2">
                <select wire:model="selectedBatch" class="border border-gray-300 rounded-lg p-2 w-full sm:w-auto focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">-- Select Batch --</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                    @endforeach
                </select>
                <button wire:click="attachBatchToEvent"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ➕ Attach
                </button>
            </div>
        </div>

        {{-- Attached Batches --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-3">📌 Attached Batches:</h3>
            <ul class="list-disc ml-6 space-y-2 text-gray-700">
                @forelse($selectedEvent->batches as $batch)
                    <li class="flex justify-between items-center border-b pb-1">
                        <span>{{ $batch->name }}</span>
                        <button wire:click="detachBatchFromEvent({{ $batch->id }})"
                                class="text-red-500 hover:text-red-700 text-sm font-medium transition">
                            Remove
                        </button>
                    </li>
                @empty
                    <li class="text-gray-500">No batches attached to this event.</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
