<div class="p-6 bg-white shadow rounded-xl">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🎓 Student Management</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Student List --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2"> Students</h3>
            <ul class="border rounded-lg p-3 max-h-64 overflow-y-auto space-y-2 bg-gray-50">
                @foreach ($students as $student)
                    <li class="border-b pb-2 cursor-pointer hover:bg-blue-100 px-2 rounded transition-all"
                        wire:click="selectStudent({{ $student->id }})">
                        {{ $student->name }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Batches Attach/Detach --}}
        <div>
            @if ($selectedStudent)
                <h3 class="text-lg font-semibold text-gray-700 mb-3"> Manage Batches for <span class="text-blue-600">{{ $selectedStudent->name }}</span></h3>

                <div class="flex items-center gap-3 mb-4">
                    <select wire:model="selectedBatch" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                        <option value="">Select Batch</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>

                    <button wire:click="attachBatch" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                        Attach
                    </button>
                </div>

                {{-- Attached Batches --}}
                <h4 class="text-md font-semibold text-gray-700 mt-4 mb-2">✅ Attached Batches:</h4>
                <ul class="list-disc ml-6 space-y-1">
                    @foreach ($selectedStudent->batches as $batch)
                        <li class="flex items-center justify-between">
                            <span>{{ $batch->name }}</span>
                            <button wire:click="detachBatch({{ $batch->id }})"
                                class="text-sm text-red-600 hover:text-red-800 transition-colors">
                                [Remove]
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
