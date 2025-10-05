# Database Backup System for SPUP Good Moral Application

This comprehensive backup system provides multiple ways to backup and restore your database safely.

## 🚀 Quick Start

### Option 1: Use the Interactive Scripts (Recommended for beginners)

**Windows Batch Script:**
```bash
# Double-click or run from command prompt
backup-database.bat
```

**PowerShell Script:**
```powershell
# Run from PowerShell
.\backup-database.ps1
```

### Option 2: Use Artisan Commands Directly

```bash
# Create a backup
php artisan db:backup

# Create a compressed backup
php artisan db:backup --compress

# List available backups
php artisan db:restore --list

# Restore from latest backup
php artisan db:restore --latest

# Restore from specific backup
php artisan db:restore backup_filename.sql
```

## 📋 Available Commands

### 1. Database Backup Command
```bash
php artisan db:backup [options]
```

**Options:**
- `--path=` : Custom backup path
- `--compress` : Compress the backup file with gzip
- `--tables=` : Backup specific tables only (comma separated)

**Examples:**
```bash
# Basic backup
php artisan db:backup

# Compressed backup
php artisan db:backup --compress

# Backup to custom location
php artisan db:backup --path=/custom/backup/path

# Backup specific tables only
php artisan db:backup --tables=users,applications,violations
```

### 2. Database Restore Command
```bash
php artisan db:restore [backup] [options]
```

**Options:**
- `--list` : List available backups
- `--latest` : Restore from latest backup
- `--force` : Force restore without confirmation

**Examples:**
```bash
# List all backups
php artisan db:restore --list

# Restore from latest backup
php artisan db:restore --latest

# Restore from specific backup
php artisan db:restore backup_GoodMoralApp_2024-01-15_14-30-25.sql

# Force restore without confirmation
php artisan db:restore --latest --force
```

### 3. Backup Management Command
```bash
php artisan backup:manage {action} [options]
```

**Actions:**
- `list` : List all backups with details
- `clean` : Remove old backups
- `delete` : Delete specific backup

**Options:**
- `--days=30` : Days to keep backups (for clean action)
- `--file=` : Specific file to delete
- `--force` : Force action without confirmation

**Examples:**
```bash
# List all backups with details
php artisan backup:manage list

# Clean backups older than 30 days
php artisan backup:manage clean --days=30

# Clean backups older than 7 days
php artisan backup:manage clean --days=7

# Delete specific backup
php artisan backup:manage delete --file=backup_GoodMoralApp_2024-01-15_14-30-25.sql

# Force clean without confirmation
php artisan backup:manage clean --days=30 --force
```

## 📁 Backup Storage

Backups are stored in: `storage/app/backups/`

**Backup filename format:**
```
backup_{database_name}_{YYYY-MM-DD_HH-mm-ss}.sql
backup_{database_name}_{YYYY-MM-DD_HH-mm-ss}.sql.gz (compressed)
```

**Example:**
```
backup_GoodMoralApp_2024-01-15_14-30-25.sql
backup_GoodMoralApp_2024-01-15_14-30-25.sql.gz
```

## 🔧 Prerequisites

1. **MySQL/MariaDB** must be installed and accessible via command line
2. **PHP** must be installed and in system PATH
3. **mysqldump** and **mysql** commands must be available
4. Proper database credentials in `.env` file

## ⚠️ Important Safety Notes

### Before Restoring:
1. **ALWAYS create a backup** before restoring
2. **Restoration will completely replace** your current database
3. **All current data will be lost** during restoration
4. **Test restores on a copy** of your production environment first

### Recommended Backup Strategy:
1. **Daily automated backups** (see scheduling section below)
2. **Manual backup before major changes**
3. **Keep multiple backup versions** (at least 30 days)
4. **Test restore process regularly**

## 📅 Automated Backup Scheduling

### Option 1: Laravel Task Scheduler
Add to `routes/console.php`:
```php
use Illuminate\Support\Facades\Schedule;

// Daily backup at 2:00 AM
Schedule::command('db:backup --compress')
    ->daily()
    ->at('02:00')
    ->name('daily-database-backup')
    ->description('Create daily compressed database backup');

// Weekly cleanup (keep 30 days)
Schedule::command('backup:manage clean --days=30 --force')
    ->weekly()
    ->sundays()
    ->at('03:00')
    ->name('weekly-backup-cleanup')
    ->description('Clean old database backups');
```

Then run the Laravel scheduler:
```bash
# Add this to your system's cron (Linux/Mac) or Task Scheduler (Windows)
php artisan schedule:run
```

### Option 2: Windows Task Scheduler
1. Open Task Scheduler
2. Create Basic Task
3. Set trigger (e.g., Daily at 2:00 AM)
4. Set action to run: `php artisan db:backup --compress`
5. Set start in: Your Laravel project directory

### Option 3: Cron Job (Linux/Mac)
```bash
# Edit crontab
crontab -e

# Add daily backup at 2:00 AM
0 2 * * * cd /path/to/your/laravel/project && php artisan db:backup --compress

# Add weekly cleanup on Sundays at 3:00 AM
0 3 * * 0 cd /path/to/your/laravel/project && php artisan backup:manage clean --days=30 --force
```

## 🛠️ Troubleshooting

### Common Issues:

**1. "mysqldump: command not found"**
- Install MySQL/MariaDB client tools
- Add MySQL bin directory to system PATH

**2. "Access denied for user"**
- Check database credentials in `.env` file
- Ensure database user has proper permissions

**3. "Permission denied" when creating backup**
- Check write permissions on `storage/app/backups/` directory
- Run: `chmod 755 storage/app/backups/` (Linux/Mac)

**4. "Backup file not found"**
- Check if backup directory exists: `storage/app/backups/`
- Verify backup was created successfully

### Getting Help:
```bash
# Get command help
php artisan help db:backup
php artisan help db:restore
php artisan help backup:manage
```

## 📊 Backup Monitoring

The system automatically tracks backup information in the `database_backups` table, including:
- Filename and path
- File size
- Creation date
- Database name

This allows you to monitor backup history and manage storage efficiently.

## 🔐 Security Considerations

1. **Backup files contain sensitive data** - store securely
2. **Limit access** to backup directory
3. **Consider encryption** for sensitive environments
4. **Regular security audits** of backup procedures
5. **Test restore procedures** regularly

## 📞 Support

For issues or questions about the backup system:
1. Check this README first
2. Review Laravel logs: `storage/logs/laravel.log`
3. Test commands manually to identify issues
4. Ensure all prerequisites are met
