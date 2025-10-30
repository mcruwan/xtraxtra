<x-university-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create Support Ticket</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Need help? Create a support ticket and our team will respond as soon as possible.
                        </p>
                    </div>
                    <a href="{{ route('university.tickets.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-blue-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Tickets
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form method="POST" action="{{ route('university.tickets.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Subject -->
                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-900 mb-2">
                            Subject <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               value="{{ old('subject') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror"
                               placeholder="Brief summary of your issue"
                               required>
                        @error('subject')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-900 mb-2">
                            Category <span class="text-red-600">*</span>
                        </label>
                        <select name="category" 
                                id="category" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white @error('category') border-red-500 @enderror"
                                required>
                            <option value="" class="text-gray-900">Select a category</option>
                            <option value="news_article" {{ old('category') == 'news_article' ? 'selected' : '' }} class="text-gray-900">News Article</option>
                            <option value="bug_report" {{ old('category') == 'bug_report' ? 'selected' : '' }} class="text-gray-900">Bug Report</option>
                            <option value="feature_request" {{ old('category') == 'feature_request' ? 'selected' : '' }} class="text-gray-900">Feature Request</option>
                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }} class="text-gray-900">General</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }} class="text-gray-900">Other</option>
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-6">
                        <label for="priority" class="block text-sm font-medium text-gray-900 mb-2">
                            Priority <span class="text-red-600">*</span>
                        </label>
                        <select name="priority" 
                                id="priority" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white @error('priority') border-red-500 @enderror"
                                required>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }} class="text-gray-900">Low - General questions or minor issues</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }} class="text-gray-900">Medium - Important but not urgent</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }} class="text-gray-900">High - Urgent issue requiring immediate attention</option>
                        </select>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-900 mb-2">
                            Description <span class="text-red-600">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="8"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Please provide as much detail as possible about your issue..."
                                  required>{{ old('description') }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">
                            Include any relevant details such as:
                            <ul class="list-disc ml-5 mt-1">
                                <li>Steps to reproduce the issue</li>
                                <li>Expected vs. actual behavior</li>
                                <li>Related news article ID (if applicable)</li>
                                <li>Screenshots or error messages</li>
                            </ul>
                        </p>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-900 mb-2">
                            Screenshot (Optional)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-3 hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-w-xs mx-auto rounded-lg shadow-sm">
                            <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove image</button>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <svg class="flex-shrink-0 w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">What happens after submission?</h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    Our support team will review your ticket and respond as soon as possible. You'll be able to view and reply to all messages in the ticket conversation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('university.tickets.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    return;
                }

                // Check file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('preview-img').src = '';
        }
    </script>
</x-university-layout>

