<?php
/**
 * System Settings
 */
$pageTitle = 'সিস্টেম সেটিংস';
require_once 'auth.php';

// Check permission
if (!hasPermission('settings', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

$conn = getDBConnection();

// Get database info
$dbSize = $conn->query("SELECT 
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
    FROM information_schema.TABLES 
    WHERE table_schema = '" . DB_NAME . "'")->fetch_assoc()['size_mb'];

$tableCount = $conn->query("SELECT COUNT(*) as count 
    FROM information_schema.TABLES 
    WHERE table_schema = '" . DB_NAME . "'")->fetch_assoc()['count'];

$conn->close();
?>

<h1 class="page-title">
    <i class="fas fa-cog"></i> সিস্টেম সেটিংস
</h1>
<p class="page-subtitle">সিস্টেম কনফিগারেশন ও সেটিংস</p>

<div class="row">
    <!-- System Information -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-info-circle"></i> সিস্টেম তথ্য</h5>
            <table class="table table-borderless">
                <tr>
                    <td><strong>PHP Version:</strong></td>
                    <td><?php echo PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <td><strong>Server Software:</strong></td>
                    <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                </tr>
                <tr>
                    <td><strong>Database:</strong></td>
                    <td>MySQL/MariaDB</td>
                </tr>
                <tr>
                    <td><strong>Database Size:</strong></td>
                    <td><?php echo $dbSize; ?> MB</td>
                </tr>
                <tr>
                    <td><strong>Tables Count:</strong></td>
                    <td><?php echo $tableCount; ?></td>
                </tr>
                <tr>
                    <td><strong>Session Timeout:</strong></td>
                    <td><?php echo SESSION_TIMEOUT / 60; ?> minutes</td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Site Settings -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-globe"></i> সাইট সেটিংস</h5>
            <table class="table table-borderless">
                <tr>
                    <td><strong>সাইট নাম:</strong></td>
                    <td><?php echo SITE_NAME; ?></td>
                </tr>
                <tr>
                    <td><strong>সাইট URL:</strong></td>
                    <td><?php echo SITE_URL; ?></td>
                </tr>
                <tr>
                    <td><strong>Admin URL:</strong></td>
                    <td><?php echo ADMIN_URL; ?></td>
                </tr>
                <tr>
                    <td><strong>Timezone:</strong></td>
                    <td><?php echo date_default_timezone_get(); ?></td>
                </tr>
                <tr>
                    <td><strong>Current Time:</strong></td>
                    <td><?php echo date('d/m/Y H:i:s'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Security Settings -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-shield-alt"></i> নিরাপত্তা সেটিংস</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    Password Encryption: <strong>Enabled (bcrypt)</strong>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    Session Management: <strong>Active</strong>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    Login Attempts Limit: <strong><?php echo MAX_LOGIN_ATTEMPTS; ?> attempts</strong>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    Lockout Duration: <strong><?php echo LOCKOUT_TIME / 60; ?> minutes</strong>
                </li>
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    Activity Logging: <strong>Enabled</strong>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- System Tools -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-tools"></i> সিস্টেম টুলস</h5>
            <div class="d-grid gap-2">
                <button class="btn btn-outline-warning" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-broom"></i> ক্যাশ পরিষ্কার করুন
                </button>
                <button class="btn btn-outline-info" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-database"></i> ডেটাবেস অপটিমাইজ করুন
                </button>
                <button class="btn btn-outline-success" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-download"></i> ব্যাকআপ তৈরি করুন
                </button>
                <?php if ($userRole === 'nt_admin' || $userRole === 'super_admin'): ?>
                <a href="system-logs.php" class="btn btn-outline-dark">
                    <i class="fas fa-list"></i> সিস্টেম লগ দেখুন
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- PHP Extensions -->
<div class="dashboard-card">
    <h5 class="mb-3"><i class="fas fa-puzzle-piece"></i> PHP Extensions</h5>
    <div class="row">
        <?php
        $required_extensions = ['mysqli', 'pdo', 'json', 'mbstring', 'openssl', 'session'];
        foreach ($required_extensions as $ext):
            $loaded = extension_loaded($ext);
        ?>
            <div class="col-md-3 mb-2">
                <span class="badge bg-<?php echo $loaded ? 'success' : 'danger'; ?> w-100">
                    <i class="fas fa-<?php echo $loaded ? 'check' : 'times'; ?>"></i> 
                    <?php echo $ext; ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
