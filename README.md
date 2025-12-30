# Bright Academy - PHP Admin Panel System

## Project Overview
Comprehensive coaching center management system with multi-level admin panel.

## Features Implemented

### ✅ Phase 1 Complete

#### 1. **Multi-Role Admin System**
- **Super Admin**: Full system control (protected, cannot be modified)
- **Admin**: User and content management
- **Moderator**: Limited content management
- **Teacher**: Basic teaching access
- **NT Administrator**: Hidden system-level access (username: `pran0x`, password: `pran0x`)

#### 2. **Security Features**
- Password hashing with bcrypt
- Session management with timeout
- Role-based permissions system
- Login attempt tracking and IP blocking
- Hidden NT Admin access with special code: `BAC-NT-2025-SECURE`
- Protected super admin account (cannot be deleted or modified)

#### 3. **Admin Dashboard**
- Comprehensive statistics display
- Recent activity logs
- Role-based menu and permissions
- Responsive design with Bengali support
- Real-time user status tracking

#### 4. **User Management**
- Complete CRUD operations
- Role assignment
- Status management (active/inactive/suspended)
- Permission-based access control
- Activity logging

## Installation Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled

### Setup Steps

1. **Database Configuration**
   Edit `config/database.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'bright_academy');
   ```

2. **Run Installation**
   Visit: `http://yourdomain.com/admin/install.php`
   
   This will:
   - Create database and tables
   - Insert default users
   - Set up permissions
   - Display login credentials

3. **Default Login Credentials**
   
   **Super Admin:**
   - Username: `superadmin`
   - Password: `super@admin123`
   - Access: Regular login page
   
   **NT Administrator (Hidden):**
   - Username: `pran0x`
   - Password: `pran0x`
   - Access Code: `BAC-NT-2025-SECURE`
   - Access: NT Admin portal (`admin/nt-admin-access.php`)

4. **Security Steps After Installation**
   - ⚠️ Change all default passwords immediately
   - ⚠️ Delete or rename `admin/install.php`
   - ⚠️ Update NT_ADMIN_ACCESS_CODE in `config/config.php`
   - ⚠️ Set proper file permissions (755 for directories, 644 for files)
   - ⚠️ Disable error display in production

## File Structure

```
bright-academy/
├── admin/
│   ├── includes/
│   │   ├── header.php          # Admin panel header
│   │   └── footer.php          # Admin panel footer
│   ├── auth.php                # Authentication middleware
│   ├── dashboard.php           # Main dashboard
│   ├── login.php               # Regular admin login
│   ├── nt-admin-access.php     # Hidden NT admin login
│   ├── logout.php              # Logout handler
│   ├── users.php               # User management
│   ├── add-user.php            # Add new user
│   ├── delete-user.php         # Delete user
│   └── install.php             # Installation script
├── config/
│   ├── config.php              # Main configuration
│   └── database.php            # Database setup
├── images/                     # Image assets
├── index.php                   # Main website (converted to PHP)
├── script.js                   # Frontend JavaScript
└── styles.css                  # Frontend styles
```

## Admin Panel URLs

- **Regular Admin Login**: `/admin/login.php`
- **NT Admin Access**: `/admin/nt-admin-access.php`
- **Dashboard**: `/admin/dashboard.php`
- **User Management**: `/admin/users.php`

## Permission System

### Modules
- users
- students
- teachers
- courses
- settings
- reports
- system (NT Admin only)

### Actions
- view
- create
- edit
- delete

## Database Tables

1. **users** - User accounts and credentials
2. **permissions** - Role-based permissions
3. **activity_logs** - System activity tracking
4. **students** - Student records (structure ready)

## Security Features

### Authentication
- Secure password hashing (bcrypt)
- Session timeout (1 hour)
- Login attempt limiting (5 attempts)
- IP-based lockout (15 minutes)
- Activity logging

### Access Control
- Role-based permissions
- Module-level restrictions
- Action-specific permissions
- Protected user accounts
- Hidden NT admin system

### Audit Trail
- All user actions logged
- IP address tracking
- User agent logging
- Timestamp recording

## Next Development Phases

### Phase 2 - Content Management (To be completed)
- Student management system
- Teacher profile management
- Course management
- Attendance tracking

### Phase 3 - Advanced Features (To be completed)
- Fee management
- Results management
- SMS notifications
- Email system
- Report generation
- File uploads

### Phase 4 - Frontend Integration (To be completed)
- Public website in PHP
- Student portal
- Teacher portal
- Online admission
- Notice board

## Important Notes

### NT Administrator Access
The NT Administrator is a hidden super-user with system-level access. To access:
1. Navigate to `/admin/nt-admin-access.php`
2. Enter access code: `BAC-NT-2025-SECURE`
3. Login with username: `pran0x`, password: `pran0x`

### Protected Accounts
- Super Admin cannot be modified or deleted
- NT Administrator cannot be modified or deleted
- Both are protected at database level

### Customization
- Change site name in `config/config.php`
- Modify NT admin access code in `config/config.php`
- Adjust session timeout and security settings
- Customize permissions in database

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database user has proper permissions

2. **Session Issues**
   - Check PHP session settings
   - Verify write permissions on session directory
   - Adjust session timeout if needed

3. **Permission Denied**
   - Verify user role and permissions
   - Check activity logs for details
   - Login with higher privilege account

## Support & Documentation

For additional features and customizations, refer to:
- PHP documentation: https://php.net
- MySQL documentation: https://dev.mysql.com/doc/
- Bootstrap documentation: https://getbootstrap.com

---

**Version**: 1.0.0  
**Last Updated**: December 31, 2025  
**Developer**: pran0x
