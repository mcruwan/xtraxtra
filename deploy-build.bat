@echo off
echo Building assets for production...
call npm run build
echo.
echo Build complete! Files are in public/build/
echo.
echo Next steps:
echo 1. Upload the entire "public/build" folder to your live server
echo 2. Make sure files are at: public/build/assets/app-iJxy6s8s.css
echo 3. Set proper permissions on the server
echo.
pause

