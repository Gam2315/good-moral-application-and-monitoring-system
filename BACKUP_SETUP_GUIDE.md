# Database Backup System Setup Guide

## 🎯 Overview

This backup system provides **TWO methods** for database backup:

1. **PHP-based backup** (✅ Works immediately, no additional setup)
2. **MySQL native backup** (⚡ Faster, requires mysqldump installation)

## 🚀 Quick Start (PHP-based backup)

**This method works immediately without any additional setup:**

```bash
# Create backup using PHP
php artisan db:backup-php

# Create compressed backup
php artisan db:backup-php --compress

# List backups
php artisan db:restore --list

# Use interactive script
backup-database.bat
```

## 📦 Installing MySQL Tools (for native backup)

### Windows Installation

**Option 1: Install MySQL Server (Recommended)**
1. Download MySQL Installer from: https://dev.mysql.com/downloads/installer/
2. Run installer and select "Custom" installation
3. Select "MySQL Server" and "MySQL Command Line Client"
4. Complete installation
5. Add MySQL bin directory to PATH:
   - Default location: `C:\Program Files\MySQL\MySQL Server 8.0\bin`
   - Add to System Environment Variables PATH

**Option 2: Install MySQL Client Only**
1. Download MySQL Community Server ZIP
2. Extract to `C:\mysql`
3. Add `C:\mysql\bin` to system PATH

**Option 3: Using Chocolatey (if installed)**
```powershell
choco install mysql
```

**Option 4: Using XAMPP/WAMP**
- If you have XAMPP: Add `C:\xampp\mysql\bin` to PATH
- If you have WAMP: Add `C:\wamp64\bin\mysql\mysql8.0.x\bin` to PATH

### Verify Installation
```bash
# Test if mysqldump is available
mysqldump --version

# Test if mysql is available  
mysql --version
```

## 🛠️ Setup Instructions

### 1. Create Backup Directory
```bash
# The system will create this automatically, but you can create it manually:
mkdir storage\app\backups
```

### 2. Test Your Setup

**Test PHP-based backup (always works):**
```bash
php artisan db:backup-php
```

**Test native backup (requires mysqldump):**
```bash
php artisan db:backup
```

### 3. Choose Your Preferred Method

**Use PHP-based backup if:**
- You don't want to install additional software
- You have a small to medium database
- You prefer simplicity

**Use native backup if:**
- You have mysqldump installed
- You have a large database (faster)
- You want industry-standard backup format

## 📋 Available Commands Summary

### PHP-based Backup Commands
```bash
# Basic PHP backup
php artisan db:backup-php

# Compressed PHP backup
php artisan db:backup-php --compress

# Backup specific tables
php artisan db:backup-php --tables=users,applications

# Custom backup location
php artisan db:backup-php --path=C:\custom\backup\path
```

### Native MySQL Backup Commands (requires mysqldump)
```bash
# Basic MySQL backup
php artisan db:backup

# Compressed MySQL backup
php artisan db:backup --compress

# Backup specific tables
php artisan db:backup --tables=users,applications
```

### Restore Commands (works with both backup types)
```bash
# List all backups
php artisan db:restore --list

# Restore latest backup
php artisan db:restore --latest

# Restore specific backup
php artisan db:restore backup_filename.sql
```

### Management Commands
```bash
# List backups with details
php artisan backup:manage list

# Clean old backups (30+ days)
php artisan backup:manage clean --days=30

# Delete specific backup
php artisan backup:manage delete --file=backup_filename.sql
```

## 🎮 Interactive Scripts

### Windows Batch Script
```bash
# Double-click or run from command prompt
backup-database.bat
```

### PowerShell Script
```powershell
# Run from PowerShell
.\backup-database.ps1

# Command line usage
.\backup-database.ps1 -Action backup -Compress
.\backup-database.ps1 -Action list
.\backup-database.ps1 -Action restore -Latest
```

## 📅 Automated Backup Setup

### Option 1: Laravel Scheduler (Recommended)

Add to `routes/console.php`:
```php
use Illuminate\Support\Facades\Schedule;

// Daily PHP backup at 2:00 AM (always works)
Schedule::command('db:backup-php --compress')
    ->daily()
    ->at('02:00')
    ->name('daily-php-backup');

// OR Daily MySQL backup (if mysqldump available)
Schedule::command('db:backup --compress')
    ->daily()
    ->at('02:00')
    ->name('daily-mysql-backup');

// Weekly cleanup
Schedule::command('backup:manage clean --days=30 --force')
    ->weekly()
    ->sundays()
    ->at('03:00');
```

Then set up Windows Task Scheduler to run:
```bash
php artisan schedule:run
```

### Option 2: Direct Windows Task Scheduler

**For PHP backup:**
- Program: `php`
- Arguments: `artisan db:backup-php --compress`
- Start in: `C:\path\to\your\laravel\project`

**For MySQL backup:**
- Program: `php`
- Arguments: `artisan db:backup --compress`
- Start in: `C:\path\to\your\laravel\project`

## 🔧 Troubleshooting

### Common Issues and Solutions

**1. "mysqldump: command not found"**
- **Solution**: Use PHP backup instead: `php artisan db:backup-php`
- **Or**: Install MySQL tools (see installation section above)

**2. "Access denied for user"**
- **Solution**: Check database credentials in `.env` file
- **Check**: DB_USERNAME, DB_PASSWORD, DB_HOST, DB_PORT

**3. "Permission denied" creating backup**
- **Solution**: Check folder permissions
- **Windows**: Right-click `storage/app/backups` → Properties → Security → Give full control

**4. "Table doesn't exist" error**
- **Solution**: Run migrations first: `php artisan migrate`

**5. Backup takes too long**
- **Solution**: Use `--tables` option to backup specific tables
- **Example**: `php artisan db:backup-php --tables=users,applications`

### Performance Comparison

| Method | Speed | File Size | Requirements |
|--------|-------|-----------|--------------|
| PHP Backup | Slower | Larger | None (built-in) |
| MySQL Backup | Faster | Smaller | mysqldump required |

### Recommended Strategy

1. **Start with PHP backup** - works immediately
2. **Install MySQL tools later** for better performance
3. **Use compressed backups** to save space
4. **Set up automated daily backups**
5. **Test restore process regularly**

## 📞 Quick Help

```bash
# Get help for any command
php artisan help db:backup-php
php artisan help db:backup
php artisan help db:restore
php artisan help backup:manage

# Check if commands are available
php artisan list | findstr backup
```

## ✅ Success Checklist

- [ ] Backup directory created: `storage/app/backups`
- [ ] PHP backup works: `php artisan db:backup-php`
- [ ] Can list backups: `php artisan db:restore --list`
- [ ] Interactive script works: `backup-database.bat`
- [ ] Automated backup scheduled (optional)
- [ ] MySQL tools installed (optional, for faster backups)

**You're ready to go! Your database is now protected with automated backups.**
