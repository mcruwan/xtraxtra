# Fix: FAQs Table Missing Error

## Problem

```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'managenewsapplie_xtraxtra.faqs' doesn't exist
```

This error occurs because the `faqs` table migration hasn't been run on the production server.

## Solution

Run the migration on your production server:

### Option 1: Using SSH/Command Line

1. **SSH into your production server** or access it via terminal
2. **Navigate to your Laravel project directory:**
   ```bash
   cd /path/to/your/project
   ```
   (For your server, it's likely something like `/home/managenewsapplie/public_html` or similar)

3. **Run the migration:**
   ```bash
   php artisan migrate --force
   ```

   The `--force` flag is required in production mode to run migrations without confirmation prompts.

### Option 2: Using Deployment Script

If you're using the deployment script (`deploy-server.sh` or `deploy-server.bat`), when prompted:
```
Do you want to run database migrations? (y/n)
```

Answer **"y"** to run all pending migrations, including the FAQs table.

## Verification

After running the migration, verify the table exists:

```bash
php artisan migrate:status
```

You should see `2025_10_30_011046_create_faqs_table.php` listed as "Ran".

Or check directly in your database:
```sql
SHOW TABLES LIKE 'faqs';
```

## What This Migration Creates

The migration creates the `faqs` table with:
- `id` - Primary key
- `university_id` - Foreign key to universities table
- `question` - FAQ question text
- `answer` - FAQ answer text
- `order` - Display order (default: 0)
- `is_active` - Active status (default: true)
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Quick Command

**Run this single command on your production server:**
```bash
php artisan migrate --force
```

## Prevention

To avoid this issue in the future:
1. **Always run migrations when deploying** - Answer "y" when the deployment script asks about migrations
2. **Check migration status before deploying** - Run `php artisan migrate:status` to see pending migrations
3. **Test migrations locally first** - Make sure migrations work in your development environment

## After Fixing

Once the migration is complete:
1. Clear Laravel caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

2. Refresh the page that was showing the error (`/university/faqs`)

3. The error should be resolved!


