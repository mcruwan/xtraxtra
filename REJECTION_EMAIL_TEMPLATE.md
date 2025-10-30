# Article Rejection Email Template - Now Editable! ✅

## Overview

The Article Rejection email template is now fully editable through the Settings page, just like the Article Approval template. Universities will receive beautifully styled emails when their articles are rejected.

## ✨ What Was Created

### 1. **Database Settings** (Migration)
   - `rejection_email_subject` - Customizable subject line
   - `rejection_email_template` - Full HTML template
   - `enable_rejection_notifications` - Enable/disable toggle

### 2. **Default Rejection Template**
   - Professional HTML template with red gradient header
   - Styled rejection reason box (orange/amber colors)
   - Article details section with red accent
   - Clear call-to-action button to view submission
   - Responsive design

### 3. **Editable Template Card**
   - Card shows Active/Inactive status badge
   - Displays last modified date
   - "Edit Template" button (not "View" anymore)
   - "Send Test" button for testing

### 4. **Modal Editor**
   - Full template editor opens when clicking the card
   - Enable/Disable toggle switch
   - Subject line editor
   - Large HTML template editor
   - 11 template variables available

### 5. **Controller Integration**
   - Handles rejection template updates
   - Validates input
   - Saves to database
   - Redirects to Email Templates tab

### 6. **Updated Notification Class**
   - Uses custom template from settings
   - Falls back to Laravel mail if Brevo not configured
   - Sends via Brevo API when configured
   - Queue support for async sending

## 📧 Template Variables

The rejection template supports these dynamic variables:

| Variable | Description |
|----------|-------------|
| `{{user_name}}` | Recipient name |
| `{{user_email}}` | Recipient email |
| `{{article_title}}` | Article title |
| `{{article_excerpt}}` | Article excerpt |
| `{{status}}` | Article status |
| `{{rejection_reason}}` | **Reason for rejection** |
| `{{rejected_at}}` | Rejection date and time |
| `{{dashboard_url}}` | Link to article |
| `{{university_name}}` | University name |
| `{{rejector_name}}` | Admin who rejected |
| `{{platform_name}}` | Platform name |

## 🎨 Default Template Preview

```
┌──────────────────────────────────────────┐
│  ✗ News Submission Rejected              │  ← Red gradient header
├──────────────────────────────────────────┤
│                                          │
│  Hello John Doe,                         │
│                                          │
│  Thank you for your submission. After   │
│  careful review, we regret to inform    │
│  you that your news article has been    │
│  rejected.                               │
│                                          │
│  ┌────────────────────────────────────┐ │
│  │ Article Details                    │ │
│  │ Title: Campus Research...          │ │  ← Red accent box
│  │ Status: Rejected                   │ │
│  │ Rejected At: Oct 30, 2025          │ │
│  │ Rejected By: Admin Smith           │ │
│  └────────────────────────────────────┘ │
│                                          │
│  ┌────────────────────────────────────┐ │
│  │ Reason for Rejection:              │ │  ← Orange/amber box
│  │ Content does not meet standards... │ │
│  └────────────────────────────────────┘ │
│                                          │
│  Please review the feedback above...    │
│                                          │
│  ┌────────────────────────────────────┐ │
│  │  View Submission in Dashboard  →   │ │  ← Red button
│  └────────────────────────────────────┘ │
│                                          │
│  If you have questions, contact us.     │
│                                          │
├──────────────────────────────────────────┤
│  Best regards,                           │  ← Footer
│  The Editorial Team                      │
│  XtraXtra                                │
└──────────────────────────────────────────┘
```

## 🚀 How to Use

### For Admins:

1. **Navigate to Settings**
   ```
   Admin Dashboard → Settings → Email Templates tab
   ```

2. **Find Article Rejection Card**
   - Red icon with "X" symbol
   - Shows current status (Active/Inactive)
   - Shows last modified date

3. **Click to Edit**
   - Click anywhere on the card
   - Modal opens with full editor

4. **Customize Template**
   - Toggle Active/Inactive
   - Edit subject line
   - Modify HTML template
   - Use template variables

5. **Save Changes**
   - Click "Save Template" button
   - Redirects to Email Templates tab
   - Success message appears

## 📁 Files Modified

1. **`database/migrations/2025_10_30_164529_add_rejection_email_template_settings.php`**
   - New migration with rejection template settings
   - Beautiful default HTML template
   - Default subject line

2. **`resources/views/admin/settings/index.blade.php`**
   - Updated rejection card to show editable status
   - Changed button text from "View" to "Edit"
   - Added editable form in modal JavaScript
   - Added 11 template variables reference

3. **`app/Http/Controllers/Admin/SettingsController.php`**
   - Updated validation to include rejection template
   - Added handling for rejection template updates
   - Saves all rejection settings to database

4. **`app/Notifications/NewsSubmissionRejected.php`**
   - Now implements `ShouldQueue` for async sending
   - Uses custom template from settings
   - Sends via Brevo API when configured
   - Falls back to Laravel mail
   - Parses template variables
   - Includes default HTML template

## 🎯 Features

### ✅ Fully Editable
- Subject line can be customized
- HTML template is fully editable
- Enable/disable notifications
- All changes save to database

### ✅ Professional Design
- Red gradient theme (rejection color)
- Rejection reason in amber/orange box
- Article details in red accent box
- Responsive layout
- Modern styling

### ✅ Dynamic Variables
- 11 template variables
- Automatic replacement
- Special `{{rejection_reason}}` variable
- Works with all email services

### ✅ Brevo API Integration
- Sends via Brevo when configured
- Falls back to Laravel mail
- Queue support
- Error logging

### ✅ Consistent with Approval Template
- Same structure and format
- Same modal editor
- Same variable system
- Same save mechanism

## 📊 Comparison

| Feature | Article Approval | Article Rejection |
|---------|-----------------|-------------------|
| Editable Template | ✅ Yes | ✅ Yes |
| Custom Subject | ✅ Yes | ✅ Yes |
| HTML Editor | ✅ Yes | ✅ Yes |
| Enable/Disable | ✅ Yes | ✅ Yes |
| Template Variables | 11 variables | 11 variables |
| Brevo Integration | ✅ Yes | ✅ Yes |
| Queue Support | ✅ Yes | ✅ Yes |
| Default Styling | Green gradient | Red gradient |

## 🧪 Testing

### Test the Template:

1. **Edit the template** in Settings → Email Templates
2. **Reject an article** as admin
3. **Check university user's email**
4. **Verify**:
   - Subject line is correct
   - Variables are replaced
   - Styling looks good
   - Rejection reason appears
   - Dashboard link works

### Test Variables:

Create a test rejection email with all variables:
```
Subject: Rejected: {{article_title}} from {{university_name}}

Body:
Hello {{user_name}},

Your article "{{article_title}}" was rejected.

Reason: {{rejection_reason}}

Rejected by {{rejector_name}} at {{rejected_at}}.

View: {{dashboard_url}}

Thanks,
{{platform_name}}
```

## 🔄 Migration

Run the migration:
```bash
php artisan migrate
```

This creates the three new settings in your database with the default template.

## 💡 Customization Examples

### Simple Text Version:
```
Subject: Article Rejected - {{article_title}}

Hello {{user_name}},

Your article "{{article_title}}" has been rejected.

Reason: {{rejection_reason}}

Please review and resubmit.

View: {{dashboard_url}}
```

### Professional HTML Version:
Use the default template or customize the colors, fonts, and layout to match your brand.

## 🎉 Summary

✅ **Article Rejection template is now fully editable**  
✅ **Beautiful default template with red theme**  
✅ **Same editing experience as Approval template**  
✅ **11 dynamic variables including rejection_reason**  
✅ **Brevo API integration ready**  
✅ **Enable/disable toggle**  
✅ **Professional styling**  

Both email templates (Approval and Rejection) are now fully customizable through the Settings page. Universities will receive consistent, professional emails for both approved and rejected articles.

---

**Version:** 1.0  
**Date:** October 30, 2025  
**Status:** ✅ Complete and Ready to Use

