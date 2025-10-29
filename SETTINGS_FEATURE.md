# Settings Feature Documentation

## Overview
A comprehensive settings management system has been added to the admin panel, allowing administrators to configure platform settings including logos and general information.

## What's Been Created

### 1. Database
- **Migration**: `2025_10_29_174442_create_settings_table.php`
  - Creates a flexible key-value settings table
  - Fields: `id`, `key`, `value`, `type`, `description`, `timestamps`
  - The `key` field is unique for efficient lookups
  - Supports different setting types: text, image, boolean, number

### 2. Model
- **Location**: `app/Models/Setting.php`
- **Features**:
  - Static `get()` method for retrieving settings with caching (1 hour)
  - Static `set()` method for updating/creating settings
  - Helper methods for logo management
  - Automatic cache invalidation on updates

### 3. Controller
- **Location**: `app/Http/Controllers/Admin/SettingsController.php`
- **Methods**:
  - `index()` - Display settings page
  - `updateLogo()` - Upload/update platform logo
  - `removeLogo()` - Delete platform logo
  - `update()` - Update general settings

### 4. Views
- **Location**: `resources/views/admin/settings/index.blade.php`
- **Sections**:
  - Platform Logo upload/management
  - General Settings (platform name, tagline, contact email)
  - Expandable structure for future settings

### 5. Routes
Added to `routes/web.php` under admin middleware:
- `GET /admin/settings` - Settings page
- `POST /admin/settings/logo` - Upload logo
- `DELETE /admin/settings/logo` - Remove logo
- `PUT /admin/settings` - Update general settings

### 6. Navigation
Updated `resources/views/layouts/admin-layout.blade.php`:
- Added "Settings" menu item with gear icon
- Positioned after "News Submissions"
- Active state highlighting included

## Features

### Platform Logo Management
- Upload logos in JPG, JPEG, PNG, GIF, or SVG format
- Maximum file size: 2MB
- Automatic old logo deletion when uploading new one
- Visual preview of current logo
- One-click logo removal

### General Settings
Currently supports:
- **Platform Name**: Displayed in headers and titles
- **Platform Tagline**: Short description
- **Contact Email**: Primary contact for support

### Extensibility
The settings system is designed to be easily expandable:
- Add new settings by using `Setting::set('key', 'value', 'type')`
- Retrieve settings with `Setting::get('key', 'default')`
- All settings are automatically cached for performance

## Usage Examples

### In Controllers
```php
use App\Models\Setting;

// Get a setting
$platformName = Setting::get('platform_name', 'Default Name');

// Set a setting
Setting::set('platform_name', 'AppliedHE Xtra! Xtra!', 'text', 'Platform name');

// Get logo URL
$logoUrl = Setting::getLogo();
```

### In Blade Templates
```php
{{ Setting::get('platform_name') }}

@if(Setting::getLogo())
    <img src="{{ Setting::getLogo() }}" alt="Platform Logo">
@endif
```

## File Storage
- Logos are stored in `storage/app/public/logos/`
- Accessible publicly via `public/storage/logos/`
- Symbolic link already configured with `php artisan storage:link`

## Future Enhancements
The settings structure supports easy addition of:
- Theme customization (colors, fonts)
- Social media links
- Email templates
- API configurations
- Feature toggles
- Maintenance mode settings
- And more...

## Access
Navigate to: **Admin Panel → Settings** (gear icon in sidebar)
- Only accessible to Super Admins and Admins
- Protected by `auth` and `admin` middleware

## Notes
- Settings are cached for 1 hour for performance
- Cache is automatically cleared when settings are updated
- All file uploads are validated for security
- Old files are automatically cleaned up to prevent storage bloat

