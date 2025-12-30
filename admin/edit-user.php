<?php
/**
 * Edit User
 */
$pageTitle = 'ব্যবহারকারী সম্পাদনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('users', 'edit')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

$error = '';
$user = null;

if (!isset($_GET['id'])) {
    showAlert('ব্যবহারকারী আইডি প্রয়োজন', 'error');
    redirectTo('users.php');
}

$editUserId = (int)$_GET['id'];

// Get user data
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $editUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    showAlert('ব্যবহারকারী পাওয়া যায়নি', 'error');
    redirectTo('users.php');
}

$user = $result->fetch_assoc();

// Check if user can be modified
if (!$user['can_be_modified']) {
    showAlert('এই ব্যবহারকারীকে সম্পাদনা করা যাবে না (Protected)', 'error');
    redirectTo('users.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $role = sanitizeInput($_POST['role']);
    $status = sanitizeInput($_POST['status']);
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($full_name) || empty($email) || empty($role)) {
        $error = 'সকল প্রয়োজনীয় ফিল্ড পূরণ করুন';
    } else {
        // Check if email exists for other users
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $editUserId);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'এই ইমেইল অন্য ব্যবহারকারী ব্যবহার করছেন';
        } else {
            // Prevent changing to super_admin or nt_admin unless current user is nt_admin
            if (($role === 'super_admin' || $role === 'nt_admin') && $userRole !== 'nt_admin') {
                $error = 'আপনার এই ভূমিকা সেট করার অনুমতি নেই';
            } else {
                // Update user
                if (!empty($password)) {
                    // Update with new password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, role = ?, status = ?, password = ? WHERE id = ?");
                    $stmt->bind_param("ssssssi", $full_name, $email, $phone, $role, $status, $hashed_password, $editUserId);
                } else {
                    // Update without changing password
                    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, role = ?, status = ? WHERE id = ?");
                    $stmt->bind_param("sssssi", $full_name, $email, $phone, $role, $status, $editUserId);
                }
                
                if ($stmt->execute()) {
                    logActivity('update_user', 'users', "Updated user ID: $editUserId");
                    showAlert('ব্যবহারকারী সফলভাবে আপডেট করা হয়েছে', 'success');
                    redirectTo('users.php');
                } else {
                    $error = 'ব্যবহারকারী আপডেট করতে ব্যর্থ হয়েছে';
                }
            }
        }
    }
}

$stmt->close();
$conn->close();

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
                    <i class="fas fa-user-edit"></i> ব্যবহারকারী সম্পাদনা
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
                        <label class="form-label">ইউজারনেম</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        <small class="text-muted">ইউজারনেম পরিবর্তন করা যায় না</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">পূর্ণ নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" required
                               value="<?php echo htmlspecialchars($user['full_name']); ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ইমেইল <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required
                               value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ফোন নম্বর</label>
                        <input type="tel" class="form-control" name="phone"
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">নতুন পাসওয়ার্ড</label>
                        <input type="password" class="form-control" name="password" minlength="6">
                        <small class="text-muted">খালি রাখলে পাসওয়ার্ড পরিবর্তন হবে না</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ভূমিকা <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <?php if ($userRole === 'nt_admin'): ?>
                                <option value="super_admin" <?php echo $user['role'] === 'super_admin' ? 'selected' : ''; ?>>সুপার এডমিন</option>
                            <?php endif; ?>
                            <?php if ($userRole === 'nt_admin' || $userRole === 'super_admin'): ?>
                                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>এডমিন</option>
                            <?php endif; ?>
                            <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>মডারেটর</option>
                            <option value="teacher" <?php echo $user['role'] === 'teacher' ? 'selected' : ''; ?>>শিক্ষক</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">অবস্থা <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>সক্রিয়</option>
                            <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                            <option value="suspended" <?php echo $user['status'] === 'suspended' ? 'selected' : ''; ?>>স্থগিত</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> আপডেট করুন
                    </button>
                    <a href="users.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> বাতিল
                    </a>
                </div>
            </form>
        </div>
        
        <!-- User Info -->
        <div class="dashboard-card mt-3">
            <h5><i class="fas fa-info-circle"></i> অতিরিক্ত তথ্য</h5>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><strong>তৈরি হয়েছে:</strong> <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></li>
                <li class="mb-2"><strong>আপডেট হয়েছে:</strong> <?php echo date('d/m/Y H:i', strtotime($user['updated_at'])); ?></li>
                <li><strong>শেষ লগইন:</strong> 
                    <?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'কখনো নয়'; ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
