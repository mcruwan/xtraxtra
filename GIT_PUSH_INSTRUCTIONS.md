# 📋 Git Push Instructions - ALWAYS BUILD BEFORE PUSHING

## ⚠️ IMPORTANT: You MUST Build Assets Before Pushing!

**Every time you want to push code to git, follow these steps:**

---

## ✅ Step-by-Step Process

### Step 1: Build Your Assets ⚡
**ALWAYS DO THIS FIRST!**

**Option A: Use the automated script (Recommended)**
```batch
build-and-push.bat
```

This script will:
- ✅ Build your assets automatically
- ✅ Stage the built files
- ✅ Commit and push everything

**Option B: Manual process**
```batch
npm run build
git add .gitignore public/build/
git commit -m "Build assets for production"
git push origin ruwan-win
```

---

### Step 2: Verify Build Was Successful

Check that these files exist:
- ✅ `public/build/manifest.json`
- ✅ `public/build/assets/app-*.css` (should exist)
- ✅ `public/build/assets/app-*.js` (should exist)

You can verify with:
```bash
git status
```

You should see `public/build/` files in the list.

---

### Step 3: Commit Your Code Changes

If you have other code changes:
```bash
git add .
git commit -m "Your commit message"
git push origin ruwan-win
```

---

## 🚫 What NOT to Do

❌ **DON'T just run `git push` without building first**
- The server won't have the latest CSS/JS files
- Users will see 404 errors
- Styles won't work correctly

❌ **DON'T skip the build step**
- Even if you only changed PHP code
- Vite may generate new file hashes
- Old files might be referenced

---

## 📝 Quick Reference

### Before Every Push:
```batch
build-and-push.bat
```

**That's it!** The script handles everything.

---

## 🔍 When Do You Need to Build?

**Build assets when:**
- ✅ You modify CSS files (`resources/css/*.css`)
- ✅ You modify JavaScript files (`resources/js/*.js`)
- ✅ You update npm packages (`package.json`)
- ✅ You change Tailwind config (`tailwind.config.js`)
- ✅ You modify Vite config (`vite.config.js`)
- ✅ **ANYTIME you push code** (to be safe)

**You DON'T need to rebuild if:**
- You only changed PHP files (.php)
- You only changed Blade templates (.blade.php)
- You only changed database migrations
- But it's still **safer to always build**

---

## 🎯 Best Practice Workflow

**Every time you make changes:**

1. **Make your code changes**
2. **Run:** `build-and-push.bat`
3. **Done!** Everything is built and pushed

**Or if you prefer manual:**

1. **Make your code changes**
2. **Run:** `npm run build`
3. **Stage changes:** `git add .`
4. **Commit:** `git commit -m "Your message"`
5. **Push:** `git push origin ruwan-win`

---

## 🆘 Troubleshooting

### "I forgot to build before pushing!"

**Solution:**
1. Build locally: `npm run build`
2. Commit the build files:
   ```bash
   git add public/build/
   git commit -m "Add missing build files"
   git push origin ruwan-win
   ```

### "The build script failed!"

**Check:**
- Do you have Node.js installed? (`node --version`)
- Do you have npm installed? (`npm --version`)
- Are you in the project root directory?

### "I see 404 errors on the server!"

**Fix:**
1. On your server, pull latest code: `git pull origin ruwan-win`
2. Verify files exist: `ls -la public/build/assets/`
3. Clear Laravel caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

---

## 📌 Reminder Checklist

Before pushing code, make sure:

- [ ] I ran `build-and-push.bat` OR manually ran `npm run build`
- [ ] I can see `public/build/manifest.json` exists
- [ ] I can see CSS and JS files in `public/build/assets/`
- [ ] I've committed the build files (they show in `git status`)
- [ ] I've pushed everything to git

---

## 💡 Pro Tips

1. **Use the script** - `build-and-push.bat` makes it impossible to forget
2. **Make it a habit** - Always build before pushing, even if you didn't change CSS/JS
3. **Check git status** - Verify build files are included before pushing
4. **Keep this file open** - Reference it until it becomes automatic

---

## 📞 Quick Commands Reference

```batch
# Build and push (one command)
build-and-push.bat

# Or manually:
npm run build
git add .
git commit -m "Your changes"
git push origin ruwan-win
```

---

**Remember: Building before pushing prevents 404 errors on your server!**

---

*Last updated: 2025-01-27*

