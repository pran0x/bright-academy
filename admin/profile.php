<?php
/**
 * User Profile
 */
$pageTitle = 'আমার প্রোফাইল';
require_once 'auth.php';

$error = '';
$success = '';

// Get user data
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    
    if (empty($full_name) || empty($email)) {
        $error = 'নাম এবং ইমেইল প্রয়োজন';
    } else {
        // Check if email exists for other users
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $userId);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'এই ইমেইল অন্য ব্যবহারকারী ব্যবহার করছেন';
        } else {
            // Update profile
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->bind_param("sssi", $full_name, $email, $phone, $userId);
            
            if ($stmt->execute()) {
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email;
                logActivity('update_profile', 'profile', 'Updated own profile');
                $success = 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে';
                
                // Refresh user data
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
            } else {
                $error = 'প্রোফাইল আপডেট করতে ব্যর্থ হয়েছে';
            }
        }
    }
}

$stmt->close();
$conn->close();

require_once 'includes/header.php';
?>

<div class="row">
    <div class="col-md-4">
        <div class="dashboard-card text-center">
            <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 40px; line-height: 100px;">
                <?php echo mb_substr($user['full_name'], 0, 1, 'UTF-8'); ?>
            </div>
            <h4><?php echo htmlspecialchars($user['full_name']); ?></h4>
            <p class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></p>
            <span class="role-badge role-<?php echo str_replace('_', '-', $user['role']); ?>">
                <?php echo getRoleName($user['role']); ?>
            </span>
            
            <hr class="my-4">
            
            <div class="text-start">
                <p class="mb-2"><i class="fas fa-envelope text-primary"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="mb-2"><i class="fas fa-phone text-success"></i> <?php echo htmlspecialchars($user['phone'] ?? 'যোগ করা হয়নি'); ?></p>
                <p class="mb-2"><i class="fas fa-calendar text-info"></i> যোগ দিয়েছেন: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                <p class="mb-0"><i class="fas fa-clock text-warning"></i> শেষ লগইন: 
                    <?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'প্রথমবার'; ?>
                </p>
            </div>
            
            <hr class="my-4">
            
            <a href="change-password.php" class="btn btn-warning w-100 mb-2">
                <i class="fas fa-key"></i> পাসওয়ার্ড পরিবর্তন
            </a>
            <a href="logout.php" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> লগআউট
            </a>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-user-edit"></i> প্রোফাইল সম্পাদনা</h4>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">পূর্ণ নাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="full_name" required
                           value="<?php echo htmlspecialchars($user['full_name']); ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ইমেইল <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" required
                           value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ফোন নম্বর</label>
                    <input type="tel" class="form-control" name="phone"
                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ইউজারনেম</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    <small class="text-muted">ইউজারনেম পরিবর্তন করা যায় না</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">ভূমিকা</label>
                    <input type="text" class="form-control" value="<?php echo getRoleName($user['role']); ?>" disabled>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> আপডেট করুন
                </button>
            </form>
        </div>
        
        <!-- Account Status -->
        <div class="dashboard-card mt-3">
            <h5><i class="fas fa-shield-alt"></i> অ্যাকাউন্ট নিরাপত্তা</h5>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <i class="fas fa-check-circle text-success"></i> 
                    অ্যাকাউন্ট স্ট্যাটাস: <strong><?php echo $user['status'] === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়'; ?></strong>
                </li>
                <li class="mb-2">
                    <i class="fas fa-lock text-info"></i> 
                    পাসওয়ার্ড: ********** 
                    <a href="change-password.php" class="btn btn-sm btn-outline-primary ms-2">পরিবর্তন করুন</a>
                </li>
                <li>
                    <i class="fas fa-user-shield text-warning"></i> 
                    দুই-ফ্যাক্টর প্রমাণীকরণ: <span class="text-muted">শীঘ্রই আসছে</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
