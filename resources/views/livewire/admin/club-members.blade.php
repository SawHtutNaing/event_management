<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Members of {{ $club->name }}</h1>
        <a href="{{ route('admin.clubs.index') }}" class="px-4 py-2 bg-gray-200 rounded">Back to Clubs</a>
    </div>

    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search members..." class="w-full md:w-1/3 px-4 py-2 border rounded">
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($members as $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $member->pivot->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($member->pivot->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->pivot->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($member->pivot->role === 'member')
                                <button wire:click="promoteToAdmin({{ $member->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Make Admin</button>
                            @else
                                <button wire:click="demoteToMember({{ $member->id }})" class="text-yellow-600 hover:text-yellow-900 mr-3">Make Member</button>
                            @endif
                            <button wire:click="removeMember({{ $member->id }})" class="text-red-600 hover:text-red-900">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
            {{ $members->links() }}
        </div>
    </div>
</div>
