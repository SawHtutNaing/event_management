<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $event ? 'Edit Event' : 'Create Event' }}</h1>

    <form wire:submit.prevent="save" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" wire:model="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                <input type="datetime-local" wire:model="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                <input type="datetime-local" wire:model="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" wire:model="location" id="location" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" wire:model="capacity" id="capacity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label for="batches" class="block text-sm font-medium text-gray-700">Select Batches</label>
                <select wire:model="selectedBatches" multiple id="batches" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @foreach($availableBatches as $batch)
                        <option value="{{ $batch['id'] }}">{{ $batch['name'] }}</option>
                    @endforeach
                </select>
                @error('selectedBatches.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Event Image</label>
                <input type="file" wire:model="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if($existingImage)
                    <div class="mt-2">
                        <span class="text-sm text-gray-500">Current Image:</span>
                        <img src="{{ asset('storage/' . $existingImage) }}" alt="Event image" class="h-20 mt-1">
                    </div>
                @endif
            </div>

            @if(auth()->user()->isAdmin())
                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_approved" id="is_approved" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_approved" class="ml-2 block text-sm text-gray-700">Approved</label>
                </div>
            @endif
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
        </div>
    </form>
</div>
