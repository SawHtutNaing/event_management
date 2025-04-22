<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Clubs</h1>
    </div>

    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search clubs..." class="w-full md:w-1/3 px-4 py-2 border rounded">
    </div>

    @if(session('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($clubs as $club)
           <a href="{{ route('clubs.show',['clubId'=> $club->id]) }}">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($club->image)
                    <img src="{{ asset('storage/'.$club->image) }}" alt="{{ $club->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $club->name }}</h2>
                    <p class="text-gray-600 mb-2">Founded by: {{ $club->founder->name }}</p>
                    <p class="text-gray-700 mb-4">{{ Str::limit($club->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $club->members()->count() }} members</span>
                        @cannot('admin')
                        @auth
                        @if($userClubs->contains($club->id))
                            <button wire:click="leaveClub({{ $club->id }})" class="px-4 py-2 bg-red-500 text-white rounded">
                                Leave Club
                            </button>
                        @else
                            <button wire:click="joinClub({{ $club->id }})" class="px-4 py-2 bg-blue-500 text-white rounded">
                                Join Club
                            </button>
                        @endif
                    @endauth
                        @endcannot

                    </div>
                </div>
            </div>
           </a>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $clubs->links() }}
    </div>
</div>
