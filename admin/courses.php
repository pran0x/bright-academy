<?php
/**
 * Courses Management
 */
$pageTitle = 'কোর্স ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('courses', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-book"></i> কোর্স ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">সকল কোর্সের তালিকা ও ব্যবস্থাপনা</p>
    </div>
    <?php if (hasPermission('courses', 'create')): ?>
    <button class="btn btn-primary" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
        <i class="fas fa-plus"></i> নতুন কোর্স যোগ করুন
    </button>
    <?php endif; ?>
</div>

<div class="dashboard-card text-center py-5">
    <i class="fas fa-book-reader fa-5x text-primary mb-4"></i>
    <h3>কোর্স ম্যানেজমেন্ট সিস্টেম</h3>
    <p class="text-muted mb-4">এই মডিউলটি শীঘ্রই যোগ করা হবে</p>
    
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-graduation-cap fa-3x text-info mb-3"></i>
                <h5>কোর্স তৈরি</h5>
                <p class="small text-muted">নতুন কোর্স তৈরি ও পরিচালনা</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-users fa-3x text-success mb-3"></i>
                <h5>ব্যাচ ম্যানেজমেন্ট</h5>
                <p class="small text-muted">ব্যাচ তৈরি ও শিক্ষার্থী নিয়োগ</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
                <h5>ক্লাস সিডিউল</h5>
                <p class="small text-muted">ক্লাসের রুটিন ও সময়সূচী</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
