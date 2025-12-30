<?php
/**
 * Results Management
 */
$pageTitle = 'ফলাফল ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('results', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-chart-bar"></i> ফলাফল ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">পরীক্ষার ফলাফল ও গ্রেড ব্যবস্থাপনা</p>
    </div>
    <?php if (hasPermission('results', 'create')): ?>
    <button class="btn btn-primary" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
        <i class="fas fa-plus"></i> নতুন ফলাফল যোগ করুন
    </button>
    <?php endif; ?>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">০</h3>
                <p class="stat-label">A+ গ্রেড</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">০</h3>
                <p class="stat-label">A গ্রেড</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">০%</h3>
                <p class="stat-label">পাসের হার</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">০</h3>
                <p class="stat-label">গড় নম্বর</p>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-card text-center py-5">
    <i class="fas fa-chart-bar fa-5x text-primary mb-4"></i>
    <h3>ফলাফল ম্যানেজমেন্ট সিস্টেম</h3>
    <p class="text-muted mb-4">এই মডিউলটি শীঘ্রই যোগ করা হবে</p>
    
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-edit fa-3x text-primary mb-3"></i>
                <h5>পরীক্ষা তৈরি</h5>
                <p class="small text-muted">নতুন পরীক্ষা ও বিষয় সংযোজন</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-clipboard-check fa-3x text-success mb-3"></i>
                <h5>নম্বর এন্ট্রি</h5>
                <p class="small text-muted">শিক্ষার্থীদের নম্বর প্রদান</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                <h5>রিপোর্ট কার্ড</h5>
                <p class="small text-muted">ফলাফল প্রকাশ ও রিপোর্ট কার্ড তৈরি</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
