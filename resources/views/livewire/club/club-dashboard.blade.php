<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $club->name }}</h1>
        @if($isAdmin)
            <a href="{{ route('club.announcements', $club->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Manage Announcements</a>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Club Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($club->image)
                    <img src="{{ asset('storage/'.$club->image) }}" alt="{{ $club->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $club->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $club->description }}</p>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>{{ $club->members()->count() }} members</span>
                        <span>Founded {{ $club->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Announcements</h2>
                </div>
                <div class="p-6">
                    @if($club->pinnedAnnouncements->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-md font-medium mb-4 text-gray-900">Pinned Announcements</h3>
                            <div class="space-y-4">
                                @foreach($club->pinnedAnnouncements as $announcement)
                                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                        <h4 class="font-semibold">{{ $announcement->title }}</h4>
                                        <p class="mt-2 text-gray-700">{{ $announcement->content }}</p>
                                        <div class="mt-3 text-sm text-gray-500">
                                            Posted by {{ $announcement->author->name }} on {{ $announcement->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <h3 class="text-md font-medium mb-4 text-gray-900">Recent Announcements</h3>
                    @if($club->announcements->count() > 0)
                        <div class="space-y-4">
                            @foreach($club->announcements->take(5) as $announcement)
                                @unless($announcement->is_pinned)
                                    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-200">
                                        <h4 class="font-semibold">{{ $announcement->title }}</h4>
                                        <p class="mt-2 text-gray-700">{{ Str::limit($announcement->content, 200) }}</p>
                                        <div class="mt-3 text-sm text-gray-500">
                                            Posted by {{ $announcement->author->name }} on {{ $announcement->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                @endunless
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No announcements yet.</p>
                    @endif

                    @if($club->announcements->count() > 5)
                        <div class="mt-4">
                            <a href="{{ route('club.announcements', $club->id) }}" class="text-blue-600 hover:text-blue-800">View all announcements</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
