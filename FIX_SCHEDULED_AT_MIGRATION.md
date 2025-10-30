# Fix for Missing scheduled_at Column Error

## Problem
The production database is missing the `scheduled_at` and `live_url` columns in the `news_submissions` table, causing SQL errors when accessing the news submission page.

**Error Message:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'scheduled_at' in 'WHERE'
```

## Temporary Fix Applied
The code has been updated to check if the `scheduled_at` column exists before querying it. This prevents the error from occurring, but the proper fix is to run the migration on production.

## Permanent Fix - Run Migration on Production

### Option 1: Using Artisan CLI (Recommended)
SSH into your production server and run:

```bash
php artisan migrate
```

This will run all pending migrations, including:
- `2025_10_30_010003_add_scheduled_status_and_live_url_to_news_submissions_table.php`

### Option 2: Manual SQL (If you prefer direct SQL)
If you need to run the migration manually, execute these SQL statements:

```sql
ALTER TABLE `news_submissions` 
ADD COLUMN `scheduled_at` TIMESTAMP NULL AFTER `approved_at`,
ADD COLUMN `live_url` VARCHAR(255) NULL AFTER `published_at`;

ALTER TABLE `news_submissions` 
MODIFY COLUMN `status` ENUM('draft', 'pending', 'approved', 'rejected', 'published', 'scheduled') DEFAULT 'draft';
```

### Option 3: Using Laravel Forge, Envoyer, or similar
If you're using a deployment service, ensure the migration is included in your deployment script:

```bash
php artisan migrate --force
```

## Verification
After running the migration, verify the columns exist:

```sql
DESCRIBE news_submissions;
```

You should see:
- `scheduled_at` column (timestamp, nullable)
- `live_url` column (varchar, nullable)
- `status` column should include 'scheduled' in the ENUM values

## Notes
- The temporary code fix allows the application to work without the column, but the `scheduled_today` count will always return 0 until the migration is run.
- Make sure to backup your database before running migrations in production.
- This migration also adds the 'scheduled' status to the status ENUM.

