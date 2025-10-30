<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create FAQ</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Add a new frequently asked question
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.faqs.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to FAQs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form - Flowbite Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                <form action="{{ route('university.faqs.store') }}" method="POST" id="faq-form">
                    @csrf

                    <div class="p-6 space-y-6">
                        <!-- Question -->
                        <div>
                            <label for="question" class="block mb-2 text-sm font-medium text-gray-900">
                                Question <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="question" id="question" value="{{ old('question') }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('question') border-red-500 bg-red-50 @enderror"
                                placeholder="Enter the question">
                            @error('question')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Enter a clear and concise question (max 500 characters).</p>
                        </div>

                        <!-- Answer -->
                        <div>
                            <label for="answer" class="block mb-2 text-sm font-medium text-gray-900">
                                Answer <span class="text-red-500">*</span>
                            </label>
                            <textarea name="answer" id="answer" required>{{ old('answer') }}</textarea>
                            @error('answer')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Provide a detailed answer to the question. You can use the formatting toolbar to style your text.</p>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block mb-2 text-sm font-medium text-gray-900">
                                Display Order <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('order') border-red-500 bg-red-50 @enderror"
                                placeholder="0">
                            @error('order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Lower numbers appear first. Leave as 0 for default ordering.</p>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm font-medium text-gray-900">Active</span>
                            </label>
                            <p class="mt-2 text-xs text-gray-500 ml-7">Only active FAQs will be displayed to users.</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <span class="text-red-500">*</span> Required fields
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('university.faqs.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" form="faq-form"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Create FAQ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery for Summernote -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Summernote CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    
    <style>
        /* Custom Summernote Styling */
        .note-editor.note-frame {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            overflow: hidden;
        }
        
        .note-editor.note-frame:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .note-toolbar {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.5rem;
        }
        
        .note-btn {
            border-radius: 0.25rem;
            transition: all 0.2s;
        }
        
        .note-btn:hover {
            background-color: #f3f4f6;
        }
        
        .note-editing-area {
            background-color: white;
        }
        
        .note-editable {
            min-height: 300px;
            padding: 0.75rem;
            font-family: Inter, Helvetica, Arial, sans-serif;
            font-size: 14px;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#answer').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</x-university-layout>
