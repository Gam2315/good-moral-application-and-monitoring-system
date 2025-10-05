# SMTP Setup Guide for Password Reset Emails

This guide will help you configure SMTP settings for the SPUP Good Moral Application System to enable password reset emails.

## Gmail SMTP Configuration

### Step 1: Enable 2-Factor Authentication
1. Go to your Google Account settings
2. Navigate to Security
3. Enable 2-Factor Authentication if not already enabled

### Step 2: Generate App Password
1. In Google Account Security settings
2. Go to "App passwords"
3. Select "Mail" and "Other (custom name)"
4. Enter "SPUP Good Moral System" as the name
5. Copy the 16-character app password generated

### Step 3: Update .env File
Replace the following values in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail-address@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-gmail-address@gmail.com"
MAIL_FROM_NAME="SPUP Good Moral Application System"
```

## Alternative SMTP Providers

### Microsoft Outlook/Hotmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@outlook.com"
MAIL_FROM_NAME="SPUP Good Moral Application System"
```

### Yahoo Mail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@yahoo.com"
MAIL_FROM_NAME="SPUP Good Moral Application System"
```

## Testing the Configuration

### Method 1: Using Test Route
1. Start your Laravel server: `php artisan serve`
2. Visit: `http://localhost:8000/test-password-reset-email/test-email@example.com`
3. Replace `test-email@example.com` with a valid email from your database

### Method 2: Using Forgot Password Form
1. Go to the login page
2. Click "Forgot Password"
3. Enter a valid email address
4. Check if the email is received

## Troubleshooting

### Common Issues:

1. **"Authentication failed"**
   - Ensure you're using an app password (not your regular password) for Gmail
   - Check that 2FA is enabled for Gmail

2. **"Connection refused"**
   - Verify SMTP host and port settings
   - Check if your hosting provider blocks SMTP ports

3. **"SSL/TLS connection failed"**
   - Try changing `MAIL_ENCRYPTION=tls` to `MAIL_ENCRYPTION=ssl`
   - Or try `MAIL_PORT=465` with `MAIL_ENCRYPTION=ssl`

4. **Emails not being sent**
   - Check Laravel logs: `storage/logs/laravel.log`
   - Verify email queue is running: `php artisan queue:work`

### Debug Commands:
```bash
# Clear config cache
php artisan config:clear

# Test email configuration
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check mail configuration
php artisan route:list | grep password
```

## Security Notes

1. **Never commit real credentials to version control**
2. **Use environment variables for sensitive data**
3. **Consider using dedicated email services for production**
4. **Regularly rotate app passwords**
5. **Monitor email sending logs**

## Production Recommendations

For production environments, consider using:
- **SendGrid** - Reliable email delivery service
- **Mailgun** - Developer-friendly email API
- **Amazon SES** - Cost-effective email service
- **Postmark** - Fast transactional email delivery

These services provide better deliverability, analytics, and reliability compared to personal email accounts.
