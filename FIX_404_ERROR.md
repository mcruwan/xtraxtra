# Fix 404 Error for Flowbite Assets on Live Server

## Problem
You're seeing this error:
```
app-iJxy6s8s.css:1 Failed to load resource: the server responded with a status of 404 ()
```

## Root Cause
The `manifest.json` file references built assets (`app-iJxy6s8s.css` and `app-6Rr135x9.js`), but these files don't exist on your live server. This happens when:
- The `public/build/assets/` directory wasn't uploaded to the server
- Files were excluded by `.gitignore` and never committed
- The build process wasn't run on the server

## ✅ Solution: Deploy the Build Files

You have **3 options** to fix this:

---

### Option 1: Build Locally and Upload (Fastest Fix)

**Step 1: On your local machine**

```bash
# Make sure you're in your project directory
cd C:\xampp\htdocs\xtraxtra

# Rebuild the assets (this will create fresh files)
npm run build
```

**Step 2: Upload the build folder to your server**

Upload the entire `public/build/` directory to your live server:
- **Source:** `C:\xampp\htdocs\xtraxtra\public\build\`
- **Destination on server:** `/path/to/your/project/public/build/`

Make sure these files exist on your server:
- ✅ `public/build/manifest.json`
- ✅ `public/build/assets/app-iJxy6s8s.css`
- ✅ `public/build/assets/app-6Rr135x9.js`

**Step 3: Set proper permissions**

On your server (via SSH or FTP):
```bash
chmod -R 755 public/build
chown -R www-data:www-data public/build  # Adjust user/group as needed
```

---

### Option 2: Build Directly on Server (Recommended)

**Via SSH, connect to your server:**

```bash
# Navigate to your project
cd /path/to/your/project

# Install dependencies (if not already installed)
npm install

# Build for production
npm run build

# Set permissions
chmod -R 755 public/build
```

**Requirements:**
- ✅ Node.js must be installed on your server
- ✅ npm must be installed
- ✅ `package.json` must exist with all dependencies

**Verify Node.js is installed:**
```bash
node --version
npm --version
```

---

### Option 3: Include Build in Git (If Using Version Control)

**Step 1: Check if `public/build/` is in `.gitignore`**

If it is, you have two choices:

**A. Remove from .gitignore (temporary)**
Edit `.gitignore` and remove or comment out:
```
# /public/build
```

Then commit:
```bash
npm run build
git add public/build/
git commit -m "Add built assets for production"
git push
```

**B. Keep .gitignore, build on server**
Keep `.gitignore` as is, and use Option 2 above.

---

## 🔍 Verify the Fix

**1. Check files exist on server:**

Via FTP/File Manager, verify:
- `public/build/manifest.json` exists
- `public/build/assets/app-iJxy6s8s.css` exists  
- `public/build/assets/app-6Rr135x9.js` exists

**2. Test in browser:**

- Visit your live site
- Open browser DevTools (F12)
- Check Console tab - no 404 errors
- Check Network tab - CSS and JS files should load with status 200

**3. Verify Flowbite works:**

- Check if styles are applied
- Test interactive components (dropdowns, modals)

---

## 🚨 If Files Still Don't Load

### Check File Paths

The manifest expects files at:
```
public/build/assets/app-iJxy6s8s.css
public/build/assets/app-6Rr135x9.js
```

Make sure the directory structure matches exactly.

### Check Web Server Configuration

**Apache (.htaccess):**
Make sure your `public/.htaccess` allows access to `build/` directory.

**Nginx:**
Ensure `public/build` is accessible in your server config.

### Check File Permissions

```bash
ls -la public/build/assets/
```

Files should be readable (644) and directories executable (755).

### Clear Laravel Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 📋 Quick Checklist

- [ ] Ran `npm run build` (locally or on server)
- [ ] `public/build/manifest.json` exists on server
- [ ] `public/build/assets/app-iJxy6s8s.css` exists on server
- [ ] `public/build/assets/app-6Rr135x9.js` exists on server
- [ ] File permissions are correct (755 for directories, 644 for files)
- [ ] Cleared Laravel caches
- [ ] Browser cache cleared (Ctrl+Shift+R or Cmd+Shift+R)

---

## 💡 Prevention for Future Deployments

**Add a deployment script or document these steps:**

1. Always run `npm run build` after pulling code
2. Or commit `public/build/` to git (if not ignored)
3. Set up a CI/CD pipeline to build automatically
4. Document the process for your team

---

## 🆘 Still Not Working?

If you've tried all the above:

1. **Delete old build files:**
   ```bash
   rm -rf public/build/*
   ```

2. **Rebuild fresh:**
   ```bash
   npm run build
   ```

3. **Check Laravel logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Verify Vite config** - Make sure `vite.config.js` is correct
5. **Check `APP_ENV`** - Should be `production` on live server
6. **Verify `APP_DEBUG`** - Should be `false` on live server

---

## Quick Command Reference

```bash
# On server via SSH
cd /path/to/project
npm install
npm run build
chmod -R 755 public/build

# Or on local, then upload via FTP/SFTP
npm run build
# Upload public/build/ folder to server
```

