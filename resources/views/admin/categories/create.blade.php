<x-admin-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create New Category</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Add a new category for news articles
                        </p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6 p-6 flex flex-col h-full">
                    @csrf

                    <!-- Category Name -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            placeholder="e.g., Academic News, Research & Innovation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 bg-red-50 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL Slug -->
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900">
                            URL Slug <span class="text-gray-400 text-xs">(Optional - auto-generated from name)</span>
                        </label>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            value="{{ old('slug') }}"
                            placeholder="e.g., academic-news"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('slug') border-red-500 bg-red-50 @enderror">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Use lowercase letters, numbers, and hyphens. Leave empty to auto-generate from the name.</p>
                    </div>

                    <!-- Description -->
                    <div class="flex-1">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                            Description <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Describe what types of articles fall under this category..."
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 bg-red-50 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Maximum 1000 characters. This helps universities understand what type of content belongs in this category.</p>
                    </div>

                    <!-- WordPress Category ID -->
                    <div>
                        <label for="wordpress_category_id" class="block mb-2 text-sm font-medium text-gray-900">
                            WordPress Category ID <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <input 
                            type="text" 
                            id="wordpress_category_id" 
                            name="wordpress_category_id" 
                            value="{{ old('wordpress_category_id') }}"
                            placeholder="e.g., academic-news, research, or category ID"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('wordpress_category_id') border-red-500 bg-red-50 @enderror">
                        @error('wordpress_category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">The WordPress category to associate articles from this category when pushing to WordPress.</p>
                    </div>

                    <!-- Form Actions - Inside the form -->
                    <div class="bg-gray-50 border-t border-gray-200 -mx-6 -mb-6 mt-6 px-6 py-4 flex items-center justify-between gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium">Cancel</a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Category
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-900">Tip</h3>
                        <p class="text-sm text-blue-800 mt-1">Choose clear, descriptive category names that help universities quickly understand what type of content belongs in each category. A good description helps prevent misclassification of articles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slug from name
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('blur', function() {
                if (slugInput.value === '' && nameInput.value !== '') {
                    // Convert to slug format
                    const slug = nameInput.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                    slugInput.value = slug;
                }
            });
        });
    </script>
</x-admin-layout>
