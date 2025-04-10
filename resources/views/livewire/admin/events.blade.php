<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manage Events</h1>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Create Event</a>
    </div>

    <div class="mb-4 flex justify-between items-center">
        <div class="w-1/3">
            <input type="text" wire:model.live="search" placeholder="Search events..." class="w-full px-4 py-2 border rounded">
        </div>
        <div class="flex space-x-2">
            <select wire:model.live="perPage" class="px-4 py-2 border rounded">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        Title
                        @if($sortField === 'title')
                            @if($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('start_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        Date
                        @if($sortField === 'start_date')
                            @if($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Location
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($events as $event)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $event->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $event->start_date->format('M j, Y g:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $event->location }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($event->is_approved)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            @if(!$event->is_approved)
                                <button wire:click="approveEvent({{ $event->id }})" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                            @endif
                            <button wire:click="deleteEvent({{ $event->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
            {{ $events->links() }}
        </div>
    </div>


</div>