@echo off
REM Build and Push Script
REM Builds assets and pushes to git for server deployment
REM Usage: build-and-push.bat

echo ==========================================
echo Building Assets and Pushing to Git
echo ==========================================
echo.

REM Step 1: Build assets
echo [1/3] Building assets for production...
call npm run build
if errorlevel 1 (
    echo Error: Build failed!
    pause
    exit /b 1
)
echo [OK] Assets built successfully
echo.

REM Step 2: Stage and commit built files
echo [2/3] Staging built files...
git add .gitignore public/build/
if errorlevel 1 (
    echo Error: Git add failed!
    pause
    exit /b 1
)
echo [OK] Files staged
echo.

REM Step 3: Commit
echo [3/3] Committing changes...
git commit -m "Build assets for production deployment"
if errorlevel 1 (
    echo Warning: Nothing to commit or commit failed
    echo This might be normal if no changes were made
)
echo.

REM Step 4: Push
echo Pushing to git...
git push origin ruwan-win
if errorlevel 1 (
    echo Error: Git push failed!
    pause
    exit /b 1
)

echo.
echo ==========================================
echo Build and push completed successfully!
echo ==========================================
echo.
echo Next steps on your server:
echo 1. Pull the latest code: git pull origin ruwan-win
echo 2. Clear Laravel caches:
echo    php artisan config:clear
echo    php artisan cache:clear
echo    php artisan view:clear
echo.
pause

