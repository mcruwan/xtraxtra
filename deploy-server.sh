#!/bin/bash

# Server Deployment Script for Laravel + Vite
# Run this script on your server after pulling code from git
# Usage: bash deploy-server.sh

echo "=========================================="
echo "Laravel Deployment Script"
echo "=========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Are you in the Laravel project root?${NC}"
    exit 1
fi

# Step 1: Pull latest code (if not already done)
read -p "Have you already pulled the latest code from git? (y/n) " -n 1 -r
echo ""
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Pulling latest code from git...${NC}"
    git pull
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error: Git pull failed!${NC}"
        exit 1
    fi
    echo -e "${GREEN}✓ Code pulled successfully${NC}"
else
    echo -e "${GREEN}✓ Skipping git pull${NC}"
fi

# Step 2: Install/Update Composer dependencies
echo ""
echo -e "${YELLOW}Installing Composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader
if [ $? -ne 0 ]; then
    echo -e "${RED}Error: Composer install failed!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Composer dependencies installed${NC}"

# Step 3: Check Node.js installation
echo ""
echo -e "${YELLOW}Checking Node.js installation...${NC}"
if ! command -v node &> /dev/null; then
    echo -e "${RED}Error: Node.js is not installed!${NC}"
    echo "Please install Node.js first: https://nodejs.org/"
    exit 1
fi
echo -e "${GREEN}✓ Node.js $(node --version) found${NC}"

# Step 4: Install/Update npm dependencies
echo ""
echo -e "${YELLOW}Installing npm dependencies...${NC}"
npm install
if [ $? -ne 0 ]; then
    echo -e "${RED}Error: npm install failed!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ npm dependencies installed${NC}"

# Step 5: Build assets (THIS FIXES THE 404 ERROR!)
echo ""
echo -e "${YELLOW}Building assets for production...${NC}"
echo "This will create the CSS and JS files referenced in manifest.json"
npm run build
if [ $? -ne 0 ]; then
    echo -e "${RED}Error: npm run build failed!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Assets built successfully${NC}"

# Step 6: Verify build files exist
echo ""
echo -e "${YELLOW}Verifying build files...${NC}"
if [ ! -f "public/build/manifest.json" ]; then
    echo -e "${RED}Error: manifest.json not found!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ manifest.json exists${NC}"

# Check if assets directory has files
if [ ! -d "public/build/assets" ] || [ -z "$(ls -A public/build/assets 2>/dev/null)" ]; then
    echo -e "${RED}Error: No assets found in public/build/assets/${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Build assets exist${NC}"

# Step 7: Set proper permissions
echo ""
echo -e "${YELLOW}Setting file permissions...${NC}"
chmod -R 755 public/build
echo -e "${GREEN}✓ Permissions set${NC}"

# Step 8: Clear Laravel caches
echo ""
echo -e "${YELLOW}Clearing Laravel caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo -e "${GREEN}✓ Caches cleared${NC}"

# Step 9: Run migrations (optional)
read -p "Do you want to run database migrations? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Running migrations...${NC}"
    php artisan migrate --force
    echo -e "${GREEN}✓ Migrations completed${NC}"
fi

# Step 10: Optimize (optional)
read -p "Do you want to optimize Laravel for production? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Optimizing Laravel...${NC}"
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo -e "${GREEN}✓ Laravel optimized${NC}"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}Deployment completed successfully!${NC}"
echo "=========================================="
echo ""
echo "Your assets have been built and are ready to serve."
echo "The 404 error for CSS/JS files should now be fixed."
echo ""
echo "If you still see errors:"
echo "1. Clear your browser cache (Ctrl+Shift+R)"
echo "2. Check file permissions: ls -la public/build/"
echo "3. Verify files exist: ls -la public/build/assets/"
echo ""

