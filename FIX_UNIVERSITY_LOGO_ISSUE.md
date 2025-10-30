# Fix University Logo Upload Issue

## Problem
University logos are uploaded successfully but appear broken (404 error) when displayed. The file path is correct (`/storage/university-logos/...`) but the files aren't accessible via HTTP.

## Root Cause
The **storage symlink** is missing or broken in production. Laravel stores files in `storage/app/public/` but they need to be accessible via `public/storage/`. A symbolic link is required to make this work.

---

## ✅ Solution

### Step 1: Check Storage Link Status

**Option A: Use the Diagnostic Tool (Recommended)**
1. Log in as admin
2. Visit: `https://yourdomain.com/admin/diagnostics/storage`
3. Review all checks - any red or yellow items need attention

**Option B: Manual Check**
```bash
# SSH into your production server
cd /path/to/your/project

# Check if symlink exists
ls -la public/storage

# You should see: public/storage -> ../storage/app/public
# If you see "No such file" or it's not a symlink, proceed to Step 2
```

### Step 2: Create the Storage Symlink

**On Linux/Mac Production Server:**
```bash
cd /path/to/your/project

# Remove existing public/storage if it's a real directory (not a symlink)
# CAUTION: Only do this if it's NOT a symlink
rm -rf public/storage  # Only if it's a directory, not a link

# Create the symlink
php artisan storage:link

# Verify it was created
ls -la public/storage
```

**On Windows Production Server:**
```batch
cd C:\path\to\your\project

REM Remove existing public\storage if it's a real directory (not a symlink)
rmdir /s public\storage

REM Create the symlink (requires Administrator privileges)
php artisan storage:link

REM Verify it was created
dir public\storage
```

### Step 3: Verify File Permissions

**Linux/Mac:**
```bash
# Make sure storage directories are writable
chmod -R 755 storage
chmod -R 755 public/storage
chown -R www-data:www-data storage  # Replace www-data with your web server user
chown -R www-data:www-data public/storage
```

**Windows:**
- Right-click `storage` folder → Properties → Security
- Ensure IIS/Apache user has Read & Write permissions

### Step 4: Verify Configuration

Check your `.env` file in production:
```env
APP_URL=https://managenews.appliedhe.com  # Must match your actual domain
```

If you changed `APP_URL`, clear the config cache:
```bash
php artisan config:clear
php artisan config:cache
```

### Step 5: Test Upload

1. Upload a test university logo
2. Check the image displays correctly
3. If still broken, check browser console for the exact URL it's trying to load

---

## 🔍 Troubleshooting

### Issue: Symlink Command Fails

**Error: "The [public/storage] link already exists"**
```bash
# Remove the existing link/directory first
rm public/storage
# or on Windows: rmdir public\storage

# Then create the symlink
php artisan storage:link
```

**Error: "symlink(): Protocol error" (Windows)**
- You need **Administrator privileges** to create symlinks on Windows
- Run Command Prompt or PowerShell as Administrator, then run:
  ```batch
  cd C:\path\to\your\project
  php artisan storage:link
  ```

### Issue: Files Upload But Still 404

**Check 1: Verify file exists in storage**
```bash
ls -la storage/app/public/university-logos/
# Files should be listed here
```

**Check 2: Verify symlink points to correct location**
```bash
ls -la public/storage
# Should show: public/storage -> ../storage/app/public
# NOT: public/storage -> /some/absolute/path
```

**Check 3: Check web server configuration**
- Apache: Ensure `FollowSymLinks` is enabled in `.htaccess` or VirtualHost
- Nginx: Ensure `disable_symlinks off;` (or not set, as off is default)

**Check 4: Verify APP_URL is correct**
```bash
# Run this and check the URL matches your domain
php artisan tinker
>>> config('filesystems.disks.public.url')
=> "https://managenews.appliedhe.com/storage"  # Should match your domain
```

### Issue: Some Logos Work, Others Don't

This suggests files uploaded before the symlink fix work, but new ones don't. Solution:
1. Verify the symlink is correctly created
2. Clear Laravel cache: `php artisan cache:clear`
3. Re-upload the broken logos

---

## 📋 Quick Checklist

After following the steps above, verify:

- ✅ Symlink exists: `public/storage` → `storage/app/public`
- ✅ Files exist in: `storage/app/public/university-logos/`
- ✅ Directory permissions are correct (755 or 777)
- ✅ Web server user owns the files
- ✅ `APP_URL` in `.env` is correct
- ✅ Config cache cleared
- ✅ Test upload shows the image correctly

---

## 🚀 Automated Fix Script

Save this as `fix-storage.sh`:

```bash
#!/bin/bash
echo "Fixing storage symlink..."

# Remove old symlink/directory if exists
if [ -e public/storage ]; then
    rm -rf public/storage
    echo "✓ Removed existing public/storage"
fi

# Create symlink
php artisan storage:link
echo "✓ Created storage symlink"

# Fix permissions
chmod -R 755 storage
chmod -R 755 public/storage
echo "✓ Fixed permissions"

# Clear cache
php artisan config:clear
php artisan cache:clear
echo "✓ Cleared cache"

echo ""
echo "============================"
echo "Storage fix completed!"
echo "============================"
echo ""
echo "Please test uploading a logo to verify it works."
```

Make it executable and run:
```bash
chmod +x fix-storage.sh
./fix-storage.sh
```

---

## 📝 Prevention for Future Deployments

Add this to your deployment script (after `git pull`):

```bash
# In your deploy script
php artisan storage:link  # Ensures symlink always exists
chmod -R 755 storage      # Ensures correct permissions
php artisan config:cache  # Refreshes configuration
```

---

## 🆘 Still Not Working?

1. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Check web server error logs:**
   - Apache: `/var/log/apache2/error.log`
   - Nginx: `/var/log/nginx/error.log`
   - Windows IIS: Event Viewer

3. **Use the diagnostic tool:**
   Visit `/admin/diagnostics/storage` for detailed system checks

4. **Test direct file access:**
   - Find a logo file path from database (e.g., `university-logos/abc123.png`)
   - Try accessing directly: `https://yourdomain.com/storage/university-logos/abc123.png`
   - If 404, the symlink is definitely the issue

---

## Technical Details

### How Laravel Storage Works

```
User uploads file
    ↓
Stored in: storage/app/public/university-logos/filename.png
    ↓
Accessed via: public/storage/university-logos/filename.png (symlink)
    ↓
URL: https://yourdomain.com/storage/university-logos/filename.png
```

### Why Symlinks Can Break

- Deploying code without running `storage:link`
- File system changes (moving project directory)
- Changing web server configuration
- Windows permission issues
- Absolute vs relative symlink paths

### Code Changes Made

1. **University Model** (`app/Models/University.php`):
   - Added `logo_url` accessor
   - Added `hasLogo()` method
   - Checks if file exists before generating URL
   - Logs warnings when files are missing

2. **Views Updated**:
   - `resources/views/admin/universities/index.blade.php`
   - `resources/views/admin/universities/edit.blade.php`
   - `resources/views/university/dashboard.blade.php`
   - `resources/views/profile/partials/update-university-information-form.blade.php`
   - All now use `$university->logo_url` accessor

3. **Diagnostic Tool Added**:
   - Controller: `app/Http/Controllers/Admin/StorageDiagnosticController.php`
   - View: `resources/views/admin/diagnostics/storage.blade.php`
   - Route: `/admin/diagnostics/storage`

---

## Contact

If issues persist after following this guide, check:
- Laravel logs: `storage/logs/laravel.log`
- The diagnostic tool: `/admin/diagnostics/storage`
- Your hosting provider's documentation for symlink support

