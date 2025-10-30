# Single Category Selection Implementation

## Summary
Updated the news article submission system to enforce **single category selection per article** instead of allowing multiple categories.

## Changes Made

### 1. Validation Rules Updated

#### File: `app/Http/Requests/NewsSubmissionRequest.php`
- Changed `categories` from `['nullable', 'array']` to `['required', 'integer', 'exists:categories,id']`
- Removed `categories.*` validation rule
- Categories are now required (not optional)

#### File: `app/Http/Requests/AdminNewsEditRequest.php`
- Changed `categories` from `['nullable', 'array']` to `['required', 'integer', 'exists:categories,id']`
- Removed `categories.*` validation rule
- Categories are now required for admin edits

### 2. Frontend Forms Updated

#### University Views

**File: `resources/views/university/news/create.blade.php`**
- Changed input type from `checkbox` to `radio` (line 114)
- Changed field name from `categories[]` to `categories` (single value)
- Updated label from "Categories (Select one or more)" to "Category" with red asterisk (required)
- Updated checked condition from `in_array()` to direct comparison: `old('categories') == $category->id`

**File: `resources/views/university/news/edit.blade.php`**
- Changed input type from `checkbox` to `radio` (line 146)
- Changed field name from `categories[]` to `categories` (single value)
- Updated label from "Categories (Select one or more)" to "Category" with red asterisk (required)
- Updated checked condition from `in_array()` to use first category: `$newsSubmission->categories->pluck('id')->first() == $category->id`

#### Admin Views

**File: `resources/views/admin/news/edit.blade.php`**
- Changed input type from `checkbox` to `radio` (line 124)
- Changed field name from `categories[]` to `categories` (single value)
- Updated label from "Categories (Select one or more)" to "Category" with red asterisk (required)
- Updated checked condition from `in_array()` to use first category: `$newsSubmission->categories->pluck('id')->first() == $category->id`

### 3. Controllers Updated

#### File: `app/Http/Controllers/University/NewsSubmissionController.php`

**In `store()` method (line 120-123):**
- Changed from: `$newsSubmission->categories()->sync($request->categories);`
- Changed to: `$newsSubmission->categories()->sync([$request->categories]);`
- Wraps single category ID in an array for the sync method

**In `update()` method (line 251-256):**
- Changed from: `$newsSubmission->categories()->sync($request->categories);`
- Changed to: `$newsSubmission->categories()->sync([$request->categories]);`
- Wraps single category ID in an array for the sync method

#### File: `app/Http/Controllers/Admin/NewsSubmissionController.php`

**In `update()` method (line 122-125):**
- Changed from: `$newsSubmission->categories()->sync($data['categories']);`
- Changed to: `$newsSubmission->categories()->sync([$data['categories']]);`
- Wraps single category ID in an array for the sync method

## Behavior Changes

### Before
- Users could select multiple categories per article using checkboxes
- Category field was optional (nullable)
- Form showed "Categories (Select one or more)"

### After
- Users can only select ONE category per article using radio buttons
- Category field is now required (mandatory)
- Form shows "Category" with a red asterisk indicating it's required
- System automatically stores only one category per article

## Testing Recommendations

1. **Create a new article:**
   - Verify only one category can be selected
   - Verify category selection is required (cannot submit without selecting one)
   - Verify attempting to select another category deselects the previous one

2. **Edit existing article:**
   - Verify the currently assigned category is pre-selected
   - Verify changing to a different category works correctly
   - Verify only one category is saved

3. **Admin editing:**
   - Verify admins see the same single-category requirement
   - Verify category changes are properly saved

4. **Validation:**
   - Verify form shows error if category is not selected on submission
   - Verify only valid category IDs are accepted

## Database Notes

- No database schema changes were required
- The `news_submission_category` pivot table continues to work
- Each article will now have at most one category record

## Browser Compatibility

Radio buttons are supported in all modern browsers and provide better UX for single-selection scenarios compared to the previous checkbox implementation.



