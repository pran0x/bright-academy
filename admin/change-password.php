<?php
/**
 * Change Password
 */
$pageTitle = 'পাসওয়ার্ড পরিবর্তন';
require_once 'auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'সকল ফিল্ড পূরণ করুন';
    } elseif ($new_password !== $confirm_password) {
        $error = 'নতুন পাসওয়ার্ড মিলছে না';
    } elseif (strlen($new_password) < 6) {
        $error = 'পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে';
    } else {
        $conn = getDBConnection();
        
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (!password_verify($current_password, $user['password'])) {
            $error = 'বর্তমান পাসওয়ার্ড ভুল';
        } else {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $userId);
            
            if ($stmt->execute()) {
                logActivity('change_password', 'security', 'Changed password');
                $success = 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে';
            } else {
                $error = 'পাসওয়ার্ড পরিবর্তন করতে ব্যর্থ হয়েছে';
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-key"></i> পাসওয়ার্ড পরিবর্তন</h4>
            
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
                    <label class="form-label">বর্তমান পাসওয়ার্ড <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="current_password" required autofocus>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="new_password" required minlength="6">
                    <small class="text-muted">কমপক্ষে ৬ অক্ষর</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm_password" required minlength="6">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> পাসওয়ার্ড পরিবর্তন করুন
                    </button>
                    <a href="profile.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> বাতিল
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Security Tips -->
        <div class="dashboard-card mt-3">
            <h5><i class="fas fa-lightbulb"></i> নিরাপত্তা টিপস</h5>
            <ul class="mb-0">
                <li>শক্তিশালী পাসওয়ার্ড ব্যবহার করুন (বড় হাতের অক্ষর, ছোট হাতের অক্ষর, সংখ্যা এবং বিশেষ চিহ্ন)</li>
                <li>অন্য কোথাও ব্যবহৃত পাসওয়ার্ড ব্যবহার করবেন না</li>
                <li>নিয়মিত পাসওয়ার্ড পরিবর্তন করুন</li>
                <li>পাসওয়ার্ড কারো সাথে শেয়ার করবেন না</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
