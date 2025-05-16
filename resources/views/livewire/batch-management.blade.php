<!-- resources/views/livewire/batch-management.blade.php -->
<div class="max-w-xl mx-auto p-6 space-y-6">
    <h2 class="text-2xl font-bold">Batch Management</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block font-medium">Batch Name</label>
            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2" placeholder="Enter batch name">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="space-x-2">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ $editingId ? 'Update' : 'Create' }}
            </button>

            @if($editingId)
                <button type="button" wire:click="resetForm"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <div>
        <h3 class="text-xl font-semibold mb-2">All Batches</h3>
        <ul class="divide-y border rounded">
            @foreach($batches as $batch)
                <li class="flex justify-between items-center p-3">
                    <span>{{ $batch->name }}</span>
                    <div class="space-x-2">
                        <button wire:click="edit({{ $batch->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Edit
                        </button>
                        <button wire:click="delete({{ $batch->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
