# Post-Deployment Checklist

## ⚠️ IMPORTANT: This checklist prevents the 404 CSS/JS error!

Every time you push code to git and deploy, you **MUST** run these steps on your server.

---

## 🚀 Quick Fix (Recommended)

After pulling code on your server, run:

### For Linux/Mac Servers:
```bash
bash deploy-server.sh
```

### For Windows Servers:
```batch
deploy-server.bat
```

---

## 📋 Manual Steps (If Not Using Script)

If you prefer to do it manually, follow these steps **every time** you deploy:

### 1. Pull Latest Code
```bash
git pull origin main  # or your branch name
```

### 2. Install PHP Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. **BUILD ASSETS** ⚠️ THIS IS CRITICAL!
```bash
npm run build
```

**This step creates the CSS and JS files that your application needs.**
**Without this, you'll get 404 errors for `app-*.css` files!**

### 5. Set Permissions (Linux/Mac)
```bash
chmod -R 755 public/build
```

### 6. Clear Laravel Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 7. (Optional) Run Migrations
```bash
php artisan migrate --force
```

### 8. (Optional) Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔍 Verify Deployment

After deployment, verify:

1. **Check build files exist:**
   ```bash
   ls -la public/build/manifest.json
   ls -la public/build/assets/
   ```

2. **Check browser console:**
   - Open your site
   - Press F12
   - Check Console tab for errors
   - Check Network tab - CSS/JS files should load with status 200

3. **Verify the site works:**
   - Styles should load correctly
   - JavaScript should work
   - No 404 errors in console

---

## ❌ Why You Get 404 Errors

The error `app-C2rjbO7F.css:1 Failed to load resource: the server responded with a status of 404` happens because:

1. ✅ Your templates use `@vite(['resources/css/app.css', 'resources/js/app.js'])`
2. ✅ Laravel looks for `public/build/manifest.json` to find the built files
3. ✅ The manifest references `app-C2rjbO7F.css` (or similar)
4. ❌ **But that file doesn't exist because `npm run build` wasn't run on the server**

**Solution:** Always run `npm run build` on your server after pulling code!

---

## 🤖 Automation Options

### Option 1: Git Hook (Recommended)

Create a post-receive hook on your server:

`.git/hooks/post-receive`:
```bash
#!/bin/bash
cd /path/to/your/project
git --git-dir=.git --work-tree=. checkout -f
npm install
npm run build
chmod -R 755 public/build
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Option 2: CI/CD Pipeline

Set up GitHub Actions, GitLab CI, or similar to automatically:
1. Pull code
2. Install dependencies
3. Run `npm run build`
4. Deploy to server

### Option 3: Deployment Script

Use the provided `deploy-server.sh` or `deploy-server.bat` scripts.

---

## 📝 Quick Reference

**Single command to fix the 404 error:**
```bash
npm run build
```

**Full deployment sequence:**
```bash
git pull && composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

---

## 💡 Pro Tips

1. **Always rebuild after code changes** - Even if you didn't change CSS/JS, Laravel's Vite plugin may generate new file hashes
2. **Check Node.js version** - Make sure your server has Node.js installed (`node --version`)
3. **Monitor build output** - If `npm run build` fails, check the error messages
4. **Keep dependencies updated** - Run `npm install` to ensure all packages are up to date

---

## 🆘 Troubleshooting

### Build fails with "Module not found"
→ Run `npm install` first

### Build succeeds but 404 persists
→ Clear browser cache (Ctrl+Shift+R)
→ Check file permissions: `chmod -R 755 public/build`
→ Verify files exist: `ls -la public/build/assets/`

### Different hash in manifest.json
→ This is normal - Vite generates new hashes for cache busting
→ Just ensure `npm run build` runs on the server

---

## ✅ Checklist Before Each Deployment

- [ ] Code pushed to git
- [ ] Pulled code on server
- [ ] Ran `composer install` (if PHP dependencies changed)
- [ ] Ran `npm install` (if JS dependencies changed)
- [ ] Ran `npm run build` ⚠️ **REQUIRED EVERY TIME**
- [ ] Set file permissions (Linux/Mac)
- [ ] Cleared Laravel caches
- [ ] Verified site works
- [ ] No 404 errors in browser console

---

**Remember: The most common cause of 404 errors is forgetting to run `npm run build` on the server!**

