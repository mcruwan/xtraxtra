# Article Approval Email Not Sending - FIX GUIDE

## Issues Found & Fixed ✅

### 1. **Notification Flow Fixed**
The `NewsSubmissionApproved` notification was sending emails via Brevo API but then still triggering Laravel's mail system as a fallback, causing duplicate attempts and confusion.

**Fix Applied:** Modified the `sendViaBrevo()` method to:
- Only send via Brevo API when configured
- Return a dummy MailMessage when Brevo succeeds (preventing duplicate sends)
- Only fallback to Laravel Mail if Brevo fails
- Added better logging for debugging

### 2. **Mail Configuration Issue Identified**
Your `MAIL_MAILER` is set to `log`, which means any fallback emails would be logged instead of sent.

**Current Status:** This is now less critical since Brevo API is being used directly, but should still be configured for the fallback to work.

---

## How to Verify Emails Are Sending

### Step 1: Check if Queue Worker is Running

Since the notification uses Laravel's queue system, you need a queue worker running:

```bash
# Check if queue worker is running
php artisan queue:work

# Or run it in the background (recommended for production)
php artisan queue:work --daemon
```

**For Windows (Development):**
```powershell
# Run in a separate terminal
php artisan queue:work
```

**For Production (Linux):**
```bash
# Use supervisor or systemd to keep it running
# Or run with nohup:
nohup php artisan queue:work --daemon > /dev/null 2>&1 &
```

### Step 2: Verify Brevo API is Configured

Run this diagnostic:

```bash
php check_email_system.php
```

You should see:
- ✅ Enable Approval Notifications: 1
- ✅ Brevo Service Configured: YES
- ✅ Bravo API Key: SET

### Step 3: Test the Email System

1. **Create a test article** as a university user
2. **Approve it** as an admin
3. **Check the logs** for confirmation:

```bash
# Check recent logs
tail -f storage/logs/laravel.log | grep -i "approval email"
```

You should see:
```
[timestamp] local.INFO: Approval email sent successfully via Brevo {"user_id":X,"user_email":"...","news_submission_id":Y}
```

### Step 4: Check Email Delivery in Brevo Dashboard

1. Go to https://app.brevo.com
2. Navigate to **Transactional > Logs**
3. Look for recent emails sent to the university user's email

---

## Alternative: Use Sync Queue (Quick Fix for Testing)

If you want to test immediately without running a queue worker:

**Option A: Temporarily disable queue for this notification**

Edit `app/Notifications/NewsSubmissionApproved.php` and remove the `ShouldQueue` interface:

```php
// Change this:
class NewsSubmissionApproved extends Notification implements ShouldQueue

// To this:
class NewsSubmissionApproved extends Notification
```

**Option B: Change queue connection to sync**

In your `.env` file, add or change:
```
QUEUE_CONNECTION=sync
```

Then restart the application:
```bash
php artisan config:cache
```

**⚠️ Note:** Using `sync` means emails are sent immediately during the approval request, which can slow down the UI. Recommended only for testing.

---

## Troubleshooting

### Issue: "Brevo Service Configured: NO"

**Solution:** Go to **Admin Dashboard > Settings > Email & API** and configure your Brevo API key.

### Issue: "Failed to send email via Brevo"

**Check:**
1. Your Brevo API key is valid
2. Your Brevo account is active
3. Check the error message in `storage/logs/laravel.log`

**Common errors:**
- Invalid API key
- Sender email not verified in Brevo
- Rate limits exceeded

### Issue: Queue jobs not processing

**Check:**
1. Queue worker is running: `php artisan queue:work`
2. Jobs table exists: Check `database/migrations/0001_01_01_000002_create_jobs_table.php`
3. Check failed jobs: `php artisan queue:failed`

---

## Production Setup Checklist

For production deployment, ensure:

- [ ] Queue worker is running via supervisor/systemd
- [ ] Brevo API key is configured in admin settings
- [ ] Sender email is verified in Brevo dashboard
- [ ] `enable_approval_notifications` is set to `1`
- [ ] Test email delivery end-to-end
- [ ] Set up monitoring for failed jobs
- [ ] Configure log rotation for `laravel.log`

---

## Quick Test Command

Run this to test email sending directly:

```bash
php artisan tinker

# Then run:
$user = User::find(1); // Replace with a test user ID
$submission = \App\Models\NewsSubmission::find(1); // Replace with a test submission ID
$user->notify(new \App\Notifications\NewsSubmissionApproved($submission));
```

Then check:
1. `storage/logs/laravel.log` for success/error messages
2. Brevo dashboard for delivery status
3. User's email inbox

---

## Summary

**What was fixed:**
✅ Notification flow to properly use Brevo API
✅ Added better logging for debugging
✅ Fixed duplicate email send attempts

**What you need to do:**
1. ✅ Start the queue worker: `php artisan queue:work`
2. ✅ Test by approving an article
3. ✅ Check logs and Brevo dashboard

**The emails should now be sending!** 🎉

