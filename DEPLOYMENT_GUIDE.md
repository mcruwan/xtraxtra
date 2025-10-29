# Flowbite Deployment Guide for Live Server

This guide explains how to properly deploy your Laravel application with Flowbite to a live production server.

## ⚠️ Important: Why Your Live Server Might Not Be Working

When you install npm packages (like Flowbite) in development, they are **not automatically included** in your production build. You need to:

1. **Build the assets** for production
2. **Commit the built files** to your repository (or deploy them separately)
3. **Run npm install and build** on the server (recommended)

## 🚀 Correct Deployment Process

### Option 1: Build Locally and Commit (Simpler)

**On your local machine:**

1. **Install dependencies** (if not already done):
   ```bash
   npm install
   ```

2. **Build for production**:
   ```bash
   npm run build
   ```

3. **Check what was created**:
   - A `public/build/` directory with compiled assets
   - A `public/build/manifest.json` file

4. **Commit the built files**:
   ```bash
   git add public/build/
   git commit -m "Build assets for production with Flowbite"
   git push
   ```

5. **On your live server:**
   - Pull the latest code (which includes `public/build/`)
   - Make sure `public/build/` directory and files are deployed
   - Your application should now work!

### Option 2: Build on Server (Recommended for Production)

**On your live server:**

1. **Navigate to your project directory**:
   ```bash
   cd /path/to/your/project
   ```

2. **Pull latest code**:
   ```bash
   git pull origin main  # or your branch name
   ```

3. **Install Node.js dependencies**:
   ```bash
   npm install
   ```
   ⚠️ **Note:** Make sure Node.js and npm are installed on your server!

4. **Build assets for production**:
   ```bash
   npm run build
   ```

5. **Set proper permissions** (if needed):
   ```bash
   chmod -R 755 public/build
   ```

6. **Clear Laravel caches**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

## 📋 What Gets Built

When you run `npm run build`, Vite will:
- ✅ Compile your CSS (`resources/css/app.css`) including Tailwind and Flowbite styles
- ✅ Compile your JavaScript (`resources/js/app.js`) including Flowbite initialization
- ✅ Create optimized, minified files in `public/build/assets/`
- ✅ Generate a `public/build/manifest.json` that Laravel uses to find the correct asset files

## 🔍 Verifying the Deployment

1. **Check that files exist on server**:
   - `public/build/manifest.json` should exist
   - `public/build/assets/` should contain `.css` and `.js` files

2. **Check browser console**:
   - Open your live site
   - Press F12 to open developer tools
   - Check the Console tab for any 404 errors (missing CSS/JS files)
   - Check the Network tab to see if CSS/JS files are loading correctly

3. **Verify Flowbite is working**:
   - Visit a page with Flowbite components
   - Check if styles are applied
   - Test interactive components (dropdowns, modals)

## 🛠️ Troubleshooting

### Problem: CSS/JS files return 404

**Solution:**
- Make sure `public/build/` directory exists
- Make sure `public/build/manifest.json` exists
- Verify file permissions: `chmod -R 755 public/build`
- Run `npm run build` again

### Problem: Flowbite styles not showing

**Solution:**
- Make sure Flowbite is in `package.json` dependencies
- Verify `tailwind.config.js` includes Flowbite plugin
- Check that `resources/js/app.js` imports Flowbite
- Rebuild: `npm run build`

### Problem: Interactive components (dropdowns, modals) not working

**Solution:**
- Make sure `resources/js/app.js` includes `import 'flowbite';`
- Rebuild: `npm run build`
- Check browser console for JavaScript errors

### Problem: "Module not found" errors on server

**Solution:**
- Make sure you ran `npm install` on the server
- Verify Node.js version matches your local development environment
- Check `package.json` exists and has correct dependencies

## 📝 Quick Checklist

Before deploying, ensure:

- [ ] `package.json` includes `flowbite` in dependencies
- [ ] `tailwind.config.js` includes Flowbite plugin
- [ ] `resources/js/app.js` imports Flowbite
- [ ] `resources/css/app.css` includes Tailwind directives
- [ ] `npm install` has been run
- [ ] `npm run build` has been run
- [ ] `public/build/` directory exists with files
- [ ] `public/build/manifest.json` exists
- [ ] Files are committed to git (or uploaded to server)

## 🌐 Server Requirements

Your live server needs:
- **Node.js** (version 14 or higher recommended)
- **npm** (comes with Node.js)
- **Laravel** environment properly configured
- Write permissions for `public/build/` directory

## 💡 Pro Tips

1. **Add to .gitignore?** 
   - Some teams ignore `public/build/` and build on server
   - Others commit it for easier deployment
   - Both work, choose what fits your workflow

2. **CI/CD Pipeline:**
   - Automate building with GitHub Actions, GitLab CI, etc.
   - Build assets as part of your deployment process

3. **Cache Busting:**
   - Vite automatically generates unique filenames
   - `manifest.json` ensures Laravel uses the correct version
   - No need to manually clear browser cache

## 📚 Additional Resources

- [Laravel Vite Documentation](https://laravel.com/docs/vite)
- [Flowbite Documentation](https://flowbite.com/docs/)
- [Vite Production Build Guide](https://vitejs.dev/guide/build.html)

