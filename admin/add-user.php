<?php
/**
 * Add New User
 */
$pageTitle = 'নতুন ব্যবহারকারী যোগ করুন';
require_once 'auth.php';

// Check permission
if (!hasPermission('users', 'create')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $role = sanitizeInput($_POST['role']);
    
    // Validation
    if (empty($username) || empty($password) || empty($full_name) || empty($email) || empty($role)) {
        $error = 'সকল প্রয়োজনীয় ফিল্ড পূরণ করুন';
    } elseif ($password !== $confirm_password) {
        $error = 'পাসওয়ার্ড মিলছে না';
    } elseif (strlen($password) < 6) {
        $error = 'পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে';
    } else {
        $conn = getDBConnection();
        
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'এই ইউজারনেম ইতিমধ্যে ব্যবহৃত হয়েছে';
        } else {
            // Check if email exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $error = 'এই ইমেইল ইতিমধ্যে ব্যবহৃত হয়েছে';
            } else {
                // Prevent creating super_admin or nt_admin unless current user is nt_admin
                if (($role === 'super_admin' || $role === 'nt_admin') && $userRole !== 'nt_admin') {
                    $error = 'আপনার এই ভূমিকা তৈরি করার অনুমতি নেই';
                } else {
                    // Insert new user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, email, phone, role, created_by) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssi", $username, $hashed_password, $full_name, $email, $phone, $role, $userId);
                    
                    if ($stmt->execute()) {
                        logActivity('create_user', 'users', "Created user: $username with role: $role");
                        showAlert('নতুন ব্যবহারকারী সফলভাবে যোগ করা হয়েছে', 'success');
                        redirectTo('users.php');
                    } else {
                        $error = 'ব্যবহারকারী যোগ করতে ব্যর্থ হয়েছে';
                    }
                }
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="users.php" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> ফিরে যান
            </a>
            <div>
                <h1 class="page-title mb-0">
                    <i class="fas fa-user-plus"></i> নতুন ব্যবহারকারী যোগ করুন
                </h1>
            </div>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="dashboard-card">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ইউজারনেম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required 
                               value="<?php echo $_POST['username'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">পূর্ণ নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" required
                               value="<?php echo $_POST['full_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ইমেইল <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required
                               value="<?php echo $_POST['email'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ফোন নম্বর</label>
                        <input type="tel" class="form-control" name="phone"
                               value="<?php echo $_POST['phone'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">পাসওয়ার্ড <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required minlength="6">
                        <small class="text-muted">কমপক্ষে ৬ অক্ষর</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_password" required minlength="6">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ভূমিকা <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="">নির্বাচন করুন</option>
                            <?php if ($userRole === 'nt_admin'): ?>
                                <option value="super_admin">সুপার এডমিন</option>
                            <?php endif; ?>
                            <?php if ($userRole === 'nt_admin' || $userRole === 'super_admin'): ?>
                                <option value="admin">এডমিন</option>
                            <?php endif; ?>
                            <option value="moderator">মডারেটর</option>
                            <option value="teacher">শিক্ষক</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> সংরক্ষণ করুন
                    </button>
                    <a href="users.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
