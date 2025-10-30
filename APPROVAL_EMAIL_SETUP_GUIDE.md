# Quick Setup Guide: Article Approval Email Notifications

## 🚀 Quick Start

Your article approval email notification system is now ready! Here's how to get started:

## ✅ What's Been Implemented

1. **Brevo Email Service** - Professional email delivery via Brevo API
2. **Approval Notification System** - Automatic emails when articles are approved
3. **Customizable Templates** - Full control over email content and design
4. **Settings Page** - Easy configuration in admin dashboard
5. **Queue Support** - Asynchronous email delivery for better performance

## 📋 Setup Steps

### Step 1: Run the Migration

```bash
php artisan migrate
```

This creates the email template settings in your database with beautiful default templates.

### Step 2: Configure Brevo API

1. Go to **Admin Dashboard → Settings → Email & API** tab
2. Enter your Brevo API credentials:
   - Get your API key from: https://app.brevo.com/settings/keys/api
   - API Secret is optional
3. Click **"Test API Key"** to verify it works
4. Click **"Save Email & API Settings"**

### Step 3: Customize Email Template (Optional)

In the same settings page, you'll find:
- **Enable/Disable Toggle** - Turn notifications on/off
- **Email Subject** - Customize the subject line
- **Email Template** - Full HTML template with styling

Available template variables:
- `{{user_name}}` - Recipient name
- `{{article_title}}` - Article title  
- `{{status}}` - Article status
- `{{approved_at}}` - Approval date
- `{{dashboard_url}}` - Link to dashboard
- `{{approver_name}}` - Admin who approved
- And more...

### Step 4: Test the Feature

1. **Create a test article** as a university user
2. **Login as admin** and go to News Submissions
3. **Approve the article**
4. **Check email** - The university user should receive a beautiful approval email

## 🎯 How It Works

### Automatic Emails Are Sent When:

1. ✅ Admin clicks "Approve" on a pending article
2. ✅ Admin bulk approves multiple articles
3. ✅ Admin changes status from "pending" to "approved" or "scheduled"

### Email Contains:

- Professional greeting
- Article details (title, status, dates)
- Clickable link to view article in dashboard
- Approver information
- Beautiful HTML styling

## 🔧 Configuration Options

### In Admin Settings → Email & API:

```
✓ Enable email notifications when articles are approved
✓ Custom email subject with variables
✓ Full HTML template customization
✓ Variable preview list
```

### Example Subject:
```
News Submission Approved - {{article_title}}
```

### Template Variables You Can Use:

| Variable | Example Output |
|----------|---------------|
| `{{user_name}}` | John Doe |
| `{{article_title}}` | New Campus Research Breakthrough |
| `{{status}}` | Approved |
| `{{approved_at}}` | October 30, 2025 at 4:30 PM |
| `{{dashboard_url}}` | https://yoursite.com/university/news/123 |
| `{{university_name}}` | Harvard University |
| `{{approver_name}}` | Admin Smith |
| `{{platform_name}}` | XtraXtra |

## 📧 Email Preview

The default email template includes:

```
┌────────────────────────────────────────┐
│  ✓ News Submission Approved            │  ← Header
├────────────────────────────────────────┤
│                                        │
│  Hello John Doe,                       │  ← Greeting
│                                        │
│  Great news! Your news submission      │  ← Message
│  has been approved by our editorial    │
│  team.                                 │
│                                        │
│  ┌──────────────────────────────────┐ │
│  │ Article Details                  │ │
│  │ Title: Campus Research...        │ │  ← Article Info
│  │ Status: Approved                 │ │
│  │ Approved At: Oct 30, 2025        │ │
│  │ Approved By: Admin Smith         │ │
│  └──────────────────────────────────┘ │
│                                        │
│  You can now view your approved        │
│  article in your dashboard.            │
│                                        │
│  ┌──────────────────────────────────┐ │
│  │  View Article in Dashboard  →    │ │  ← Action Button
│  └──────────────────────────────────┘ │
│                                        │
│  Thank you for your contribution!      │
│                                        │
├────────────────────────────────────────┤
│  Best regards,                         │  ← Footer
│  The Editorial Team                    │
│  XtraXtra                              │
└────────────────────────────────────────┘
```

## 🎨 Customization Examples

### Simple Text Email:
```html
Hello {{user_name}},

Your article "{{article_title}}" has been approved!

Status: {{status}}
Approved by: {{approver_name}}
Approved at: {{approved_at}}

View it here: {{dashboard_url}}

Thanks,
{{platform_name}}
```

### Professional HTML Email:
```html
<!DOCTYPE html>
<html>
<head>
    <style>
        .container { max-width: 600px; margin: 0 auto; }
        .header { background: #667eea; color: white; padding: 20px; }
        .content { padding: 30px; }
        .button { background: #667eea; color: white; padding: 12px 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Article Approved</h1>
        </div>
        <div class="content">
            <p>Hello {{user_name}},</p>
            <p>Great news! Your article "{{article_title}}" has been approved.</p>
            <a href="{{dashboard_url}}" class="button">View Article</a>
        </div>
    </div>
</body>
</html>
```

## ⚡ Queue Setup (Important!)

For production, run the queue worker:

```bash
# Development
php artisan queue:work

# Production (use supervisor)
# Add to /etc/supervisor/conf.d/laravel-worker.conf
```

This ensures emails are sent asynchronously without slowing down the approval process.

## 🔍 Troubleshooting

### Emails Not Sending?

1. ✓ Check Brevo API is configured in settings
2. ✓ Click "Test API Key" to verify connection
3. ✓ Ensure "Enable email notifications" is checked
4. ✓ Run `php artisan queue:work`
5. ✓ Check logs: `storage/logs/laravel.log`

### Variables Not Replacing?

- Use exact variable names: `{{user_name}}` not `{{username}}`
- Include double curly braces
- Check spelling (case-sensitive)

### Brevo API Issues?

- Verify API key permissions
- Check API quota in Brevo dashboard
- Ensure base URL is correct (default: https://api.brevo.com)

## 📊 Monitoring

### Check Email Logs:
```bash
tail -f storage/logs/laravel.log | grep -i "email"
```

### View Notifications in Database:
```sql
SELECT * FROM notifications WHERE type = 'App\\Notifications\\NewsSubmissionApproved' ORDER BY created_at DESC LIMIT 10;
```

### Test Brevo Connection:
```bash
php artisan tinker
$service = new \App\Services\BrevoMailService();
$service->testConnection();
```

## 🎓 Usage Examples

### Scenario 1: Single Approval
1. Admin views pending article
2. Clicks "Approve" button
3. System sends email to university user
4. Admin sees: "News submission has been approved successfully! The university has been notified."

### Scenario 2: Bulk Approval
1. Admin selects multiple pending articles
2. Clicks "Approve Selected"
3. System sends email to each university user
4. Admin sees: "5 submission(s) approved successfully and universities have been notified!"

### Scenario 3: Scheduled Approval
1. Admin approves article with future date
2. Status becomes "Scheduled"
3. Email includes scheduled publication date
4. University user knows when article will be published

## 🔐 Security Notes

- API credentials stored securely in database
- Email links use authenticated routes
- Template variables are sanitized
- Queue jobs are logged

## 📚 Additional Resources

- Full documentation: `EMAIL_NOTIFICATION_FEATURE.md`
- Brevo API Docs: https://developers.brevo.com/
- Laravel Notifications: https://laravel.com/docs/notifications
- Laravel Queues: https://laravel.com/docs/queues

## 🎉 You're All Set!

The system is ready to use. Just configure your Brevo API key and approve an article to see it in action!

---

**Need Help?** Check `storage/logs/laravel.log` for detailed error messages.

