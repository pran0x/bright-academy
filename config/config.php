<?php
/**
 * Main Configuration File
 * Bright Academic Care - Admin Panel System
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Site Configuration
define('SITE_NAME', 'ব্রাইট একাডেমিক কেয়ার');
define('SITE_URL', 'http://localhost/bright-academy');
define('ADMIN_URL', SITE_URL . '/admin');

// Directory paths
define('ROOT_PATH', dirname(__DIR__));
define('ADMIN_PATH', ROOT_PATH . '/admin');
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');

// Security settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes

// NT Admin Access Code (hidden code required to access NT admin login)
define('NT_ADMIN_ACCESS_CODE', 'BAC-NT-2025-SECURE');

// Timezone
date_default_timezone_set('Asia/Dhaka');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once __DIR__ . '/database.php';

// Initialize database on first run
if (!file_exists(__DIR__ . '/.installed')) {
    initializeDatabase();
    file_put_contents(__DIR__ . '/.installed', date('Y-m-d H:i:s'));
}

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function hasPermission($module, $action) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $role = getUserRole();
    
    // NT Admin and Super Admin have all permissions
    if ($role === 'nt_admin' || $role === 'super_admin') {
        return true;
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT can_view, can_create, can_edit, can_delete 
                            FROM permissions 
                            WHERE role = ? AND module = ?");
    $stmt->bind_param("ss", $role, $module);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $actionMap = [
            'view' => 'can_view',
            'create' => 'can_create',
            'edit' => 'can_edit',
            'delete' => 'can_delete'
        ];
        
        $column = $actionMap[$action] ?? 'can_view';
        return (bool)$row[$column];
    }
    
    return false;
}

function redirectTo($url) {
    header("Location: $url");
    exit();
}

function logActivity($action, $module, $details = null) {
    if (!isLoggedIn()) {
        return;
    }
    
    $userId = getUserId();
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, module, details, ip_address, user_agent) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $userId, $action, $module, $details, $ipAddress, $userAgent);
    $stmt->execute();
    $stmt->close();
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function showAlert($message, $type = 'info') {
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}

function displayAlert() {
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        $alertClass = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info'
        ][$alert['type']] ?? 'alert-info';
        
        echo "<div class='alert {$alertClass} alert-dismissible fade show' role='alert'>
                {$alert['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION['alert']);
    }
}

function getRoleName($role) {
    $roles = [
        'super_admin' => 'সুপার এডমিন',
        'admin' => 'এডমিন',
        'moderator' => 'মডারেটর',
        'teacher' => 'শিক্ষক',
        'nt_admin' => 'NT Administrator'
    ];
    return $roles[$role] ?? $role;
}
?>
