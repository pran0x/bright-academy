<?php
/**
 * Attendance Management
 */
$pageTitle = 'উপস্থিতি ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('attendance', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

// Get today's date
$today = date('Y-m-d');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-calendar-check"></i> উপস্থিতি ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">শিক্ষার্থীদের উপস্থিতি রেকর্ড</p>
    </div>
    <?php if (hasPermission('attendance', 'create')): ?>
    <button class="btn btn-primary" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
        <i class="fas fa-plus"></i> আজকের উপস্থিতি নিন
    </button>
    <?php endif; ?>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">আজ উপস্থিত</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">আজ অনুপস্থিত</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">এই মাসে বিলম্ব</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">0%</h3>
                <p class="stat-label">গড় উপস্থিতির হার</p>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-card text-center py-5">
    <i class="fas fa-calendar-check fa-5x text-primary mb-4"></i>
    <h3>উপস্থিতি ব্যবস্থাপনা সিস্টেম</h3>
    <p class="text-muted mb-4">এই মডিউলটি শীঘ্রই যোগ করা হবে</p>
    
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                <h5>দৈনিক উপস্থিতি</h5>
                <p class="small text-muted">প্রতিদিনের উপস্থিতি নিবন্ধন</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                <h5>উপস্থিতি রিপোর্ট</h5>
                <p class="small text-muted">বিস্তারিত উপস্থিতি বিশ্লেষণ</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                <h5>অনুপস্থিতি সতর্কতা</h5>
                <p class="small text-muted">স্বয়ংক্রিয় অনুপস্থিতির বিজ্ঞপ্তি</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
