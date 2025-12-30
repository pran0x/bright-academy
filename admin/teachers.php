<?php
/**
 * Teachers Management
 */
$pageTitle = 'শিক্ষক ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('teachers', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

// Get all teacher users
$conn = getDBConnection();
$teachers = $conn->query("SELECT * FROM users WHERE role = 'teacher' ORDER BY full_name ASC")->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-chalkboard-teacher"></i> শিক্ষক ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">সকল শিক্ষকদের তালিকা ও ব্যবস্থাপনা</p>
    </div>
    <?php if (hasPermission('users', 'create')): ?>
    <a href="add-user.php" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> নতুন শিক্ষক যোগ করুন
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <?php if (empty($teachers)): ?>
        <div class="col-12">
            <div class="dashboard-card text-center py-5">
                <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">কোন শিক্ষক পাওয়া যায়নি</h4>
                <p class="text-muted">নতুন শিক্ষক যোগ করতে উপরের বাটনে ক্লিক করুন</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($teachers as $teacher): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="dashboard-card">
                    <div class="text-center mb-3">
                        <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px; line-height: 80px;">
                            <?php echo mb_substr($teacher['full_name'], 0, 1, 'UTF-8'); ?>
                        </div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($teacher['full_name']); ?></h5>
                        <p class="text-muted mb-2">@<?php echo htmlspecialchars($teacher['username']); ?></p>
                        <span class="badge bg-<?php echo $teacher['status'] === 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo $teacher['status'] === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়'; ?>
                        </span>
                    </div>
                    
                    <div class="small">
                        <p class="mb-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <?php echo htmlspecialchars($teacher['email']); ?>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-phone text-success"></i>
                            <?php echo htmlspecialchars($teacher['phone'] ?? 'যোগ করা হয়নি'); ?>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-calendar text-info"></i>
                            যোগ দিয়েছেন: <?php echo date('d/m/Y', strtotime($teacher['created_at'])); ?>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-clock text-warning"></i>
                            শেষ লগইন: <?php echo $teacher['last_login'] ? date('d/m/Y', strtotime($teacher['last_login'])) : 'কখনো নয়'; ?>
                        </p>
                    </div>
                    
                    <div class="mt-3 d-flex gap-2">
                        <?php if (hasPermission('users', 'edit')): ?>
                        <a href="edit-user.php?id=<?php echo $teacher['id']; ?>" class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-edit"></i> সম্পাদনা
                        </a>
                        <?php endif; ?>
                        <a href="#" class="btn btn-sm btn-info flex-fill" onclick="alert('বিস্তারিত দেখা শীঘ্রই আসছে')">
                            <i class="fas fa-eye"></i> বিস্তারিত
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Teacher Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="dashboard-card text-center">
            <h3 class="text-success"><?php echo count(array_filter($teachers, fn($t) => $t['status'] === 'active')); ?></h3>
            <p class="mb-0">সক্রিয় শিক্ষক</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card text-center">
            <h3 class="text-secondary"><?php echo count(array_filter($teachers, fn($t) => $t['status'] !== 'active')); ?></h3>
            <p class="mb-0">নিষ্ক্রিয় শিক্ষক</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card text-center">
            <h3 class="text-primary"><?php echo count($teachers); ?></h3>
            <p class="mb-0">মোট শিক্ষক</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
