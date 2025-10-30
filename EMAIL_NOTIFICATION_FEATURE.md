# Email Notification Feature for Article Approvals

## Overview

This feature automatically sends email notifications to university users when their submitted news articles are approved by administrators. The system uses the Brevo API for email delivery and provides customizable email templates.

## Features

- ✅ Automatic email notifications when articles are approved
- ✅ Customizable email templates with variable placeholders
- ✅ Support for both approved and scheduled article statuses
- ✅ Toggle to enable/disable notifications
- ✅ Beautiful HTML email templates
- ✅ Fallback to Laravel's default mail system if Brevo is not configured
- ✅ Queue support for async email sending

## Components

### 1. BrevoMailService (`app/Services/BrevoMailService.php`)

A service class that handles communication with the Brevo API:
- Sends transactional emails
- Sends template-based emails
- Tests API connection
- Provides detailed logging

### 2. NewsSubmissionApproved Notification (`app/Notifications/NewsSubmissionApproved.php`)

A Laravel notification class that:
- Sends emails via Brevo when configured
- Falls back to Laravel's mail system
- Supports database notifications
- Parses template variables dynamically

### 3. Email Template Settings

Stored in the database with the following keys:
- `approval_email_subject` - Email subject line
- `approval_email_template` - HTML email template
- `enable_approval_notifications` - Toggle for enabling/disabling notifications

### 4. Settings Page Integration

Added to the "Email & API" tab in admin settings with:
- Toggle to enable/disable notifications
- Email subject field
- HTML template editor
- List of available template variables

## Configuration

### Step 1: Configure Brevo API

1. Navigate to **Admin Dashboard > Settings > Email & API**
2. Enter your Brevo API credentials:
   - **API Key**: Your Brevo API key
   - **API Secret**: Your Brevo API secret (optional)
   - **API Base URL**: Default is `https://api.brevo.com` (optional)
3. Click "Test API Key" to verify connection
4. Click "Save Email & API Settings"

### Step 2: Configure Email Template

In the same settings page:

1. Enable notifications by checking "Enable email notifications when articles are approved"
2. Customize the email subject (default: `News Submission Approved - {{article_title}}`)
3. Edit the HTML template to match your brand
4. Click "Save Email & API Settings"

### Step 3: Available Template Variables

Use these variables in your email subject and template:

| Variable | Description |
|----------|-------------|
| `{{user_name}}` | Recipient name |
| `{{user_email}}` | Recipient email |
| `{{article_title}}` | Article title |
| `{{article_excerpt}}` | Article excerpt |
| `{{status}}` | Article status (Approved/Scheduled) |
| `{{approved_at}}` | Approval date and time |
| `{{scheduled_at}}` | Scheduled publication date (if applicable) |
| `{{dashboard_url}}` | Link to article in dashboard |
| `{{university_name}}` | University name |
| `{{approver_name}}` | Name of admin who approved |
| `{{platform_name}}` | Platform name (from settings) |

## Usage

### When Emails Are Sent

Emails are automatically sent when:

1. **Single Approval**: Admin clicks "Approve" button on a pending article
2. **Bulk Approval**: Admin selects multiple articles and approves them
3. **Status Update**: Admin changes article status from "pending" to "approved" or "scheduled"

### Email Content

The default email includes:
- Greeting with user's name
- Article details (title, status, approval date)
- Link to view the article in dashboard
- Approver information
- Professional footer

### Customization Example

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Article Approved</title>
</head>
<body>
    <h1>Hello {{user_name}},</h1>
    <p>Your article "{{article_title}}" has been approved!</p>
    <p><strong>Status:</strong> {{status}}</p>
    <p><strong>Approved by:</strong> {{approver_name}}</p>
    <p><a href="{{dashboard_url}}">View in Dashboard</a></p>
    <p>Thank you,<br>{{platform_name}} Team</p>
</body>
</html>
```

## Technical Details

### Email Delivery Flow

1. Admin approves article
2. System checks if notifications are enabled
3. If enabled, creates `NewsSubmissionApproved` notification
4. Notification checks if Brevo API is configured
5. If yes, sends via Brevo API with custom template
6. If no, falls back to Laravel's mail system
7. Notification is also stored in database for in-app viewing

### Queue Support

The notification implements `ShouldQueue` interface, meaning emails are sent asynchronously via Laravel's queue system. Make sure to run:

```bash
php artisan queue:work
```

Or configure a supervisor/systemd service for production.

### Logging

All email activities are logged in `storage/logs/laravel.log`:
- Successful sends
- Failed sends with error details
- API connection issues

### Error Handling

- If Brevo API is not configured, system falls back to Laravel's mail
- If email sending fails, error is logged but doesn't break the approval flow
- Users still see success message for approval even if email fails

## Testing

### Manual Testing

1. Create a test university user
2. Submit a test article as that user
3. Login as admin
4. Navigate to pending articles
5. Approve the test article
6. Check:
   - Admin sees success message with "The university has been notified"
   - University user receives email
   - Email contains correct information with clickable link
   - Database has notification record

### Using Laravel Tinker

```php
// Test Brevo connection
$service = new \App\Services\BrevoMailService();
$result = $service->testConnection();
dd($result);

// Send test email
$submission = \App\Models\NewsSubmission::first();
$submission->user->notify(new \App\Notifications\NewsSubmissionApproved($submission));
```

## Troubleshooting

### Emails Not Being Sent

1. Check if notifications are enabled in settings
2. Verify Brevo API credentials
3. Test API key using "Test API Key" button
4. Check queue is running: `php artisan queue:work`
5. Review logs in `storage/logs/laravel.log`

### Template Variables Not Replacing

- Ensure variables are wrapped in double curly braces: `{{variable_name}}`
- Check spelling matches exactly
- Variables are case-sensitive

### Brevo API Errors

- Verify API key has correct permissions
- Check API quota hasn't been exceeded
- Ensure base URL is correct
- Review Brevo dashboard for additional details

## Database Schema

### Settings Table Additions

```sql
INSERT INTO settings (key, value, type, description) VALUES
('approval_email_subject', 'News Submission Approved - {{article_title}}', 'text', 'Subject line for article approval emails'),
('approval_email_template', '<html>...</html>', 'textarea', 'HTML template for article approval emails'),
('enable_approval_notifications', '1', 'boolean', 'Enable email notifications when articles are approved');
```

## Security Considerations

- API credentials are stored in database (consider encryption)
- Emails contain links to dashboard (ensure HTTPS in production)
- Template variables are sanitized to prevent XSS
- Queue jobs should be monitored for failures

## Future Enhancements

Potential improvements:
- [ ] Multiple email templates for different scenarios
- [ ] Email preview in settings
- [ ] Send test email button
- [ ] Email delivery status tracking
- [ ] Retry failed emails
- [ ] Localization support
- [ ] SMS notifications via Brevo

## Migration Commands

```bash
# Run migration
php artisan migrate

# Rollback if needed
php artisan migrate:rollback
```

## Related Files

- `app/Services/BrevoMailService.php` - Brevo API service
- `app/Notifications/NewsSubmissionApproved.php` - Approval notification
- `app/Http/Controllers/Admin/NewsSubmissionController.php` - Approval logic
- `app/Http/Controllers/Admin/SettingsController.php` - Settings management
- `resources/views/admin/settings/index.blade.php` - Settings UI
- `database/migrations/2025_10_30_162429_add_email_template_settings_to_settings_table.php` - Database migration

## Support

For issues or questions:
1. Check logs in `storage/logs/laravel.log`
2. Review Brevo API documentation: https://developers.brevo.com/
3. Test with simple template first, then add complexity
4. Verify database has template settings after migration

---

**Version:** 1.0  
**Last Updated:** October 30, 2025  
**Author:** AI Assistant

