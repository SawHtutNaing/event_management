    <div>
        @if($show)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-gray-700">{{ $content }}</p>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button 
                            wire:click="resetModal" 
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            wire:click="delete" 
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>