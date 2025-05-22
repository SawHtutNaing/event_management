<div class="p-6 bg-white shadow rounded-xl">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🎓 Student Management</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Students List with Checkboxes --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Students</h3>
            <ul class="border rounded-lg p-3 max-h-64 overflow-y-auto space-y-2 bg-gray-50">
                @foreach ($students as $student)
                    <li class="flex items-center gap-2 border-b pb-2 px-2">
                        <input type="checkbox" wire:model="selectedStudentIds" value="{{ $student->id }}">
                        <span>{{ $student->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Attach Batch Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Attach Batch to Selected Students</h3>

            <div class="flex items-center gap-3 mb-4">
                <select wire:model="selectedBatch"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                    <option value="">Select Batch</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                    @endforeach
                </select>

                <button wire:click="attachBatch"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                    Attach to Selected
                </button>
            </div>

            {{-- Show Attached Batches per Student --}}
            {{-- <div class="mt-6">
                <h4 class="text-md font-semibold text-gray-700 mb-2">✅ Attached Batches (per student):</h4>
                <ul class="space-y-4">
                    @foreach ($students as $student)
                        @if ($student->batches->isNotEmpty())
                            <li>
                                <div class="font-semibold text-gray-800">{{ $student->name }}</div>
                                <ul class="list-disc ml-6">
                                    @foreach ($student->batches as $batch)
                                        <li class="flex items-center justify-between">
                                            <span>{{ $batch->name }}</span>
                                            <button wire:click="detachBatch({{ $student->id }}, {{ $batch->id }})"
                                                class="text-sm text-red-600 hover:text-red-800 transition-colors">
                                                [Remove]
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div> --}}
        </div>
    </div>
</div>
