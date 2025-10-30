# Fix for Missing Database Objects in Production

## Problems
The production database is missing several database objects, causing SQL errors:

### Problem 1: Missing `scheduled_at` Column
**Error Message:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'scheduled_at' in 'WHERE'
```
**Affected:** `/admin/news` page

### Problem 2: Missing `faqs` Table
**Error Message:**
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'faqs' doesn't exist
```
**Affected:** `/admin/faqs` page

### Problem 3: Missing `settings` Table
**Error Message:**
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'settings' doesn't exist
```
**Affected:** `/admin/settings` page

## Temporary Fix Applied
The code has been updated with safety checks:
- `NewsSubmissionController`: Checks if `scheduled_at` column exists before querying it
- `FaqController`: Checks if `faqs` table exists before querying it
- `SettingsController`: Checks if `settings` table exists before querying it

These fixes prevent errors from occurring, but the proper fix is to run the migrations on production.

## Permanent Fix - Run Migrations on Production

### Option 1: Using Artisan CLI (Recommended)
SSH into your production server and run:

```bash
php artisan migrate
```

This will run all pending migrations, including:
- `2025_10_29_174442_create_settings_table.php`
- `2025_10_29_175023_add_type_and_description_to_settings_table.php`
- `2025_10_30_010003_add_scheduled_status_and_live_url_to_news_submissions_table.php`
- `2025_10_30_011046_create_faqs_table.php`

### Option 2: Manual SQL (If you prefer direct SQL)

#### For scheduled_at column:
```sql
ALTER TABLE `news_submissions` 
ADD COLUMN `scheduled_at` TIMESTAMP NULL AFTER `approved_at`,
ADD COLUMN `live_url` VARCHAR(255) NULL AFTER `published_at`;

ALTER TABLE `news_submissions` 
MODIFY COLUMN `status` ENUM('draft', 'pending', 'approved', 'rejected', 'published', 'scheduled') DEFAULT 'draft';
```

#### For settings table:
```sql
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### For faqs table:
```sql
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `university_id` bigint(20) unsigned NOT NULL,
  `question` text NOT NULL,
  `answer` longtext NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_university_id_foreign` (`university_id`),
  CONSTRAINT `faqs_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Option 3: Using Laravel Forge, Envoyer, or similar
If you're using a deployment service, ensure the migrations are included in your deployment script:

```bash
php artisan migrate --force
```

## Verification

### Verify scheduled_at column:
```sql
DESCRIBE news_submissions;
```
You should see:
- `scheduled_at` column (timestamp, nullable)
- `live_url` column (varchar, nullable)
- `status` column should include 'scheduled' in the ENUM values

### Verify settings table:
```sql
SHOW TABLES LIKE 'settings';
DESCRIBE settings;
```
The table should exist with columns: id, key, value, type, description, created_at, updated_at

### Verify faqs table:
```sql
SHOW TABLES LIKE 'faqs';
DESCRIBE faqs;
```
The table should exist with columns: id, university_id, question, answer, order, is_active, created_at, updated_at

## Notes
- The temporary code fixes allow the application to work without these database objects:
  - `scheduled_today` count will return 0 until the migration is run
  - FAQ pages will show empty results until the migration is run
  - Settings page will show empty settings and display a warning until the migration is run
- Make sure to backup your database before running migrations in production.
- All migrations should be run in the correct order to maintain database integrity.
- The settings table migration includes two files (create table, then add columns) - both should be run.

