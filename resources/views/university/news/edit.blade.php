<x-university-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header - Flowbite -->
            <div class="mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit News Submission</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Update your news submission details
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('university.news.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Banner for Approved/Published Articles -->
            @if(in_array($newsSubmission->status, ['approved', 'published']))
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Editing {{ ucfirst($newsSubmission->status) }} Article</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>When you save changes to this {{ $newsSubmission->status }} article, it will automatically be resubmitted for admin approval with "pending" status.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Banner for Rejected Articles -->
            @if($newsSubmission->status === 'rejected')
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Resubmitting Rejected Article</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>This article was previously rejected. When you save changes, it will be resubmitted for admin review with "pending" status. Please address the feedback provided in the rejection reason.</p>
                                @if($newsSubmission->rejection_reason)
                                    <div class="mt-2 p-2 bg-white rounded border border-red-200">
                                        <p class="text-xs font-medium text-red-900 mb-1">Previous Rejection Reason:</p>
                                        <p class="text-xs text-red-800">{{ $newsSubmission->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form - Flowbite Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                <form action="{{ route('university.news.update', $newsSubmission) }}" method="POST" enctype="multipart/form-data" id="news-form">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $newsSubmission->title) }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('title') border-red-500 bg-red-50 @enderror"
                                placeholder="Enter news title">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug (Optional) -->
                        <div>
                            <label for="slug" class="block mb-2 text-sm font-medium text-gray-900">
                                Slug <span class="text-gray-400 text-xs">(Optional - auto-generated from title)</span>
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $newsSubmission->slug) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('slug') border-red-500 bg-red-50 @enderror"
                                placeholder="news-url-slug">
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Used in the URL. Leave empty to auto-generate.</p>
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block mb-2 text-sm font-medium text-gray-900">
                                Excerpt <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <textarea name="excerpt" id="excerpt" rows="3"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('excerpt') border-red-500 bg-red-50 @enderror"
                                placeholder="Brief summary of the news (max 500 characters)">{{ old('excerpt', $newsSubmission->excerpt) }}</textarea>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">This will be used as the preview text in listings.</p>
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block mb-2 text-sm font-medium text-gray-900">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" id="content" rows="15"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 bg-red-50 @enderror"
                                required>{{ old('content', $newsSubmission->content) }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Featured Image -->
                        @if($newsSubmission->featured_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Image</label>
                                <img src="{{ asset('storage/' . $newsSubmission->featured_image) }}" alt="{{ $newsSubmission->title }}" 
                                    class="max-w-sm rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <!-- Featured Image -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                {{ $newsSubmission->featured_image ? 'Replace Featured Image' : 'Featured Image' }} 
                                <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <div class="flex items-center space-x-4">
                                <button type="button" id="choose-image-btn" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Choose Image
                                </button>
                                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                                <span id="file-name" class="text-sm text-gray-500">No file chosen</span>
                            </div>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Recommended size: 1200x630px. Max 2MB.</p>
                            <div id="image-preview" class="mt-4 hidden">
                                <img src="" alt="Preview" class="max-w-sm rounded-lg border border-gray-200">
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($categories as $category)
                                    <label class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 cursor-pointer">
                                        <input type="radio" name="categories" value="{{ $category->id }}" 
                                            {{ $newsSubmission->categories->pluck('id')->first() == $category->id ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                            @if($category->description)
                                                <p class="text-xs text-gray-500">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tag-input" class="block mb-2 text-sm font-medium text-gray-900">
                                Tags
                            </label>
                            
                            <!-- Tag Input Row -->
                            <div class="flex gap-2 mb-3">
                                <div class="flex-1 relative">
                                    <input 
                                        type="text" 
                                        id="tag-input" 
                                        placeholder="Type a tag name..."
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        autocomplete="off"
                                    >
                                    <!-- Tag Suggestions Dropdown -->
                                    <div id="tag-suggestions" class="absolute z-10 mt-1 w-full border border-gray-200 rounded-lg bg-white shadow-lg hidden max-h-48 overflow-y-auto"></div>
                                </div>
                                <button 
                                    type="button" 
                                    id="add-tag-btn"
                                    class="px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Selected Tags Display -->
                            <div id="tag-display" class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200 min-h-[60px]">
                                <span class="text-xs text-gray-500 flex items-center">No tags added yet. Type a tag name and click the + button to add.</span>
                            </div>
                            
                            <!-- Hidden inputs for form submission -->
                            <div id="tag-inputs"></div>
                            
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Add relevant tags to help categorize your news article.</p>
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                                Submission Status
                            </label>
                            <select name="status" id="status" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="draft" {{ old('status', $newsSubmission->status) === 'draft' ? 'selected' : '' }}>Draft (Save for later)</option>
                                <option value="pending" {{ old('status', $newsSubmission->status) === 'pending' ? 'selected' : '' }}>Submit for Review</option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500">Choose whether to save as draft or submit for admin review.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Floating Action Bar -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <span class="text-red-500">*</span> Required fields
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit" form="news-form" name="status" value="draft"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 transition-colors">
                            Save as Draft
                        </button>
                        <button type="submit" form="news-form" name="status" value="pending"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                            Submit for Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Spacer to prevent content from being hidden behind floating bar -->
        <div class="h-20"></div>
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
            min-height: 400px;
            padding: 0.75rem;
            font-family: Inter, Helvetica, Arial, sans-serif;
            font-size: 14px;
        }
    </style>
    
    <script>
        (function() {
            // Store all available tags
            const availableTags = @json($tags);
            let selectedTags = @json($newsSubmission->tags);
            
            // Initialize Summernote editor
            document.addEventListener('DOMContentLoaded', function() {
                $('#content').summernote({
                    height: 500,
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
            
            
            // Check if tag is already selected
            function isTagSelected(tagName) {
                return selectedTags.some(tag => 
                    tag.name.toLowerCase() === tagName.toLowerCase()
                );
            }

            // Add tag
            function addTag(tagName) {
                // Check if tag exists in available tags
                let existingTag = availableTags.find(tag => 
                    tag.name.toLowerCase() === tagName.toLowerCase()
                );
                
                if (existingTag) {
                    // Check if not already in selected tags
                    if (!selectedTags.some(tag => tag.id === existingTag.id)) {
                        selectedTags.push(existingTag);
                    }
                } else {
                    // Create new tag (client-side only, server will create it)
                    if (!selectedTags.some(tag => tag.name.toLowerCase() === tagName.toLowerCase())) {
                        selectedTags.push({
                            id: 'new-' + Date.now(),
                            name: tagName
                        });
                    }
                }
                
                updateTagDisplay();
                updateHiddenInputs();
            }

            // Remove tag
            function removeTag(tagId) {
                selectedTags = selectedTags.filter(tag => tag.id !== tagId);
                updateTagDisplay();
                updateHiddenInputs();
            }

            // Update tag display
            function updateTagDisplay() {
                const tagDisplay = document.getElementById('tag-display');
                tagDisplay.innerHTML = '';
                
                if (selectedTags.length === 0) {
                    tagDisplay.innerHTML = '<span class="text-xs text-gray-500 flex items-center">No tags added yet. Type a tag name and click the + button to add.</span>';
                    return;
                }
                
                selectedTags.forEach(tag => {
                    const tagBadge = document.createElement('span');
                    tagBadge.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium bg-brand-100 text-brand-800 border border-brand-200 transition hover:bg-brand-200';
                    
                    const tagText = document.createElement('span');
                    tagText.textContent = tag.name;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'flex-shrink-0 ml-1 hover:text-brand-900';
                    removeBtn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    `;
                    removeBtn.onclick = function() {
                        removeTag(tag.id);
                    };
                    
                    tagBadge.appendChild(tagText);
                    tagBadge.appendChild(removeBtn);
                    tagBadge.setAttribute('data-tag-id', tag.id);
                    tagDisplay.appendChild(tagBadge);
                });
            }

            // Update hidden inputs for form submission
            function updateHiddenInputs() {
                const tagInputs = document.getElementById('tag-inputs');
                tagInputs.innerHTML = '';
                
                selectedTags.forEach(tag => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'tag_names[]'; // Send tag names instead of IDs
                    input.value = tag.name;
                    tagInputs.appendChild(input);
                });
            }

            // Suggest tags based on input
            function suggestTags(searchTerm) {
                if (!searchTerm || searchTerm.length < 1) {
                    hideTagSuggestions();
                    return;
                }
                
                const term = searchTerm.toLowerCase();
                const suggestionsContainer = document.getElementById('tag-suggestions');
                const matches = availableTags.filter(tag => 
                    tag.name.toLowerCase().includes(term) && 
                    !isTagSelected(tag.name)
                ).slice(0, 10);
                
                if (matches.length === 0) {
                    hideTagSuggestions();
                    return;
                }
                
                suggestionsContainer.innerHTML = '';
                matches.forEach(tag => {
                    const item = document.createElement('div');
                    item.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                    item.textContent = tag.name;
                    item.onclick = () => {
                        addTag(tag.name);
                        document.getElementById('tag-input').value = '';
                        hideTagSuggestions();
                    };
                    suggestionsContainer.appendChild(item);
                });
                
                suggestionsContainer.classList.remove('hidden');
            }

            // Hide tag suggestions
            function hideTagSuggestions() {
                document.getElementById('tag-suggestions').classList.add('hidden');
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateTagDisplay();
                updateHiddenInputs();
                
                const tagInput = document.getElementById('tag-input');
                const addTagBtn = document.getElementById('add-tag-btn');
                
                // Add tag when button is clicked
                addTagBtn.addEventListener('click', function() {
                    const tagName = tagInput.value.trim();
                    
                    if (tagName && !isTagSelected(tagName)) {
                        addTag(tagName);
                        tagInput.value = '';
                        hideTagSuggestions();
                        tagInput.focus();
                    }
                });
                
                // Also add tag when Enter is pressed (optional but nice UX)
                tagInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        addTagBtn.click();
                    }
                });
                
                // Show suggestions as user types
                tagInput.addEventListener('input', function() {
                    suggestTags(this.value);
                });
                
                // Hide suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#tag-input') && !e.target.closest('#tag-suggestions') && !e.target.closest('#add-tag-btn')) {
                        hideTagSuggestions();
                    }
                });
            });
        
        })();
        
        // Image preview function (outside IIFE so it's globally accessible)
        window.previewImage = function(event) {
            const file = event.target.files[0];
            const fileName = document.getElementById('file-name');
            const preview = document.getElementById('image-preview');
            
            if (!fileName || !preview) return;
            
            const previewImg = preview.querySelector('img');

            if (file) {
                fileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                    }
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'No file chosen';
                preview.classList.add('hidden');
            }
        };
        
        // Ensure file upload button works - explicit button click handler
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('featured_image');
            const chooseBtn = document.getElementById('choose-image-btn');
            
            if (chooseBtn && fileInput) {
                chooseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fileInput.click();
                });
            }
        });
    </script>
</x-university-layout>

