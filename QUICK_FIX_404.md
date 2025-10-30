# ⚡ Quick Fix: 404 CSS/JS Error

## The Problem
```
app-C2rjbO7F.css:1 Failed to load resource: the server responded with a status of 404 ()
```

## The Solution (30 seconds)

**Run these commands on your server after EVERY git pull:**

```bash
npm install
npm run build
```

That's it! This creates the CSS and JS files that your app needs.

---

## Why This Happens

- `public/build/` is in `.gitignore` (not committed to git)
- When you pull code, the build files don't exist on the server
- Laravel looks for files that aren't there → 404 error

---

## One-Line Fix

```bash
npm install && npm run build && php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

---

## Automated Script

**Linux/Mac:**
```bash
bash deploy-server.sh
```

**Windows:**
```batch
deploy-server.bat
```

---

## Full Documentation

- See `POST_DEPLOYMENT_CHECKLIST.md` for complete steps
- See `DEPLOYMENT_GUIDE.md` for detailed explanation

---

**Remember: Run `npm run build` on your server after every deployment!**

