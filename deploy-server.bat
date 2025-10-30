@echo off
REM Server Deployment Script for Laravel + Vite (Windows)
REM Run this script on your server after pulling code from git
REM Usage: deploy-server.bat

echo ==========================================
echo Laravel Deployment Script
echo ==========================================
echo.

REM Check if we're in a Laravel project
if not exist "artisan" (
    echo Error: artisan file not found. Are you in the Laravel project root?
    pause
    exit /b 1
)

REM Step 1: Pull latest code (if not already done)
echo Have you already pulled the latest code from git?
set /p pulled="(y/n): "
if /i "%pulled%" NEQ "y" (
    echo.
    echo Pulling latest code from git...
    git pull
    if errorlevel 1 (
        echo Error: Git pull failed!
        pause
        exit /b 1
    )
    echo [OK] Code pulled successfully
) else (
    echo [OK] Skipping git pull
)

REM Step 2: Install/Update Composer dependencies
echo.
echo Installing Composer dependencies...
call composer install --no-dev --optimize-autoloader
if errorlevel 1 (
    echo Error: Composer install failed!
    pause
    exit /b 1
)
echo [OK] Composer dependencies installed

REM Step 3: Check Node.js installation
echo.
echo Checking Node.js installation...
where node >nul 2>&1
if errorlevel 1 (
    echo Error: Node.js is not installed!
    echo Please install Node.js first: https://nodejs.org/
    pause
    exit /b 1
)
for /f "tokens=*" %%i in ('node --version') do set NODE_VERSION=%%i
echo [OK] Node.js %NODE_VERSION% found

REM Step 4: Install/Update npm dependencies
echo.
echo Installing npm dependencies...
call npm install
if errorlevel 1 (
    echo Error: npm install failed!
    pause
    exit /b 1
)
echo [OK] npm dependencies installed

REM Step 5: Build assets (THIS FIXES THE 404 ERROR!)
echo.
echo Building assets for production...
echo This will create the CSS and JS files referenced in manifest.json
call npm run build
if errorlevel 1 (
    echo Error: npm run build failed!
    pause
    exit /b 1
)
echo [OK] Assets built successfully

REM Step 6: Verify build files exist
echo.
echo Verifying build files...
if not exist "public\build\manifest.json" (
    echo Error: manifest.json not found!
    pause
    exit /b 1
)
echo [OK] manifest.json exists

dir /b "public\build\assets" >nul 2>&1
if errorlevel 1 (
    echo Error: No assets found in public\build\assets\
    pause
    exit /b 1
)
echo [OK] Build assets exist

REM Step 7: Clear Laravel caches
echo.
echo Clearing Laravel caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear
echo [OK] Caches cleared

REM Step 8: Run migrations (optional)
echo.
echo Do you want to run database migrations?
set /p migrate="(y/n): "
if /i "%migrate%"=="y" (
    echo Running migrations...
    call php artisan migrate --force
    echo [OK] Migrations completed
)

REM Step 9: Optimize (optional)
echo.
echo Do you want to optimize Laravel for production?
set /p optimize="(y/n): "
if /i "%optimize%"=="y" (
    echo Optimizing Laravel...
    call php artisan config:cache
    call php artisan route:cache
    call php artisan view:cache
    echo [OK] Laravel optimized
)

echo.
echo ==========================================
echo Deployment completed successfully!
echo ==========================================
echo.
echo Your assets have been built and are ready to serve.
echo The 404 error for CSS/JS files should now be fixed.
echo.
echo If you still see errors:
echo 1. Clear your browser cache (Ctrl+Shift+R)
echo 2. Check file permissions on public/build/
echo 3. Verify files exist in public/build/assets/
echo.
pause

