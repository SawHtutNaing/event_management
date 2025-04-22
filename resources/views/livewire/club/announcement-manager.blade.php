<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Announcements for {{ $club->name }}</h1>
        <button wire:click="create" class="px-4 py-2 bg-blue-500 text-white rounded">New Announcement</button>
    </div>

    @if(session('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if($showForm)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ $announcementId ? 'Edit Announcement' : 'Create Announcement' }}</h2>

            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea wire:model="content" id="content" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isPinned" id="isPinned" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="isPinned" class="ml-2 block text-sm text-gray-700">Pin this announcement</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    @endif

    <div class="space-y-6">
        @foreach($announcements as $announcement)
            <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 {{ $announcement->is_pinned ? 'border-blue-500' : 'border-gray-200' }}">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold mb-2">{{ $announcement->title }}</h3>
                        @if($isAdmin)
                            <div class="flex space-x-2">
                                <button wire:click="togglePin({{ $announcement->id }})" class="text-gray-500 hover:text-blue-500">
                                    @if($announcement->is_pinned)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                                        </svg>
                                    @endif
                                </button>
                                <button wire:click="edit({{ $announcement->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                                <button wire:click="delete({{ $announcement->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        @endif
                    </div>
                    <div class="prose max-w-none">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        Posted by {{ $announcement->author->name }} on {{ $announcement->created_at->format('M d, Y \a\t h:i A') }}
                        @if($announcement->is_pinned)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Pinned
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $announcements->links() }}
    </div>
</div>
