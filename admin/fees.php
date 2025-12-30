<?php
/**
 * Fee Management
 */
$pageTitle = 'ফি ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('fees', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-dollar-sign"></i> ফি ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">শিক্ষার্থীদের ফি ও পেমেন্ট ব্যবস্থাপনা</p>
    </div>
    <?php if (hasPermission('fees', 'create')): ?>
    <button class="btn btn-primary" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
        <i class="fas fa-plus"></i> নতুন পেমেন্ট যোগ করুন
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
                <h3 class="stat-number">৩০,০০০ ৳</h3>
                <p class="stat-label">এই মাসে সংগৃহীত</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">১৫,০০০ ৳</h3>
                <p class="stat-label">বকেয়া ফি</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">০</h3>
                <p class="stat-label">পেমেন্ট বাকি</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">১,২০,০০০ ৳</h3>
                <p class="stat-label">মোট আয় (বছর)</p>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-card text-center py-5">
    <i class="fas fa-money-bill-wave fa-5x text-success mb-4"></i>
    <h3>ফি ম্যানেজমেন্ট সিস্টেম</h3>
    <p class="text-muted mb-4">এই মডিউলটি শীঘ্রই যোগ করা হবে</p>
    
    <div class="row mt-5">
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="fas fa-file-invoice-dollar fa-3x text-primary mb-3"></i>
                <h5>ফি স্ট্রাকচার</h5>
                <p class="small text-muted">কোর্স ভিত্তিক ফি নির্ধারণ</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="fas fa-receipt fa-3x text-success mb-3"></i>
                <h5>পেমেন্ট রেকর্ড</h5>
                <p class="small text-muted">ফি পেমেন্ট সংরক্ষণ ও রসিদ</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="fas fa-bell fa-3x text-warning mb-3"></i>
                <h5>পেমেন্ট রিমাইন্ডার</h5>
                <p class="small text-muted">বকেয়া ফি এর বিজ্ঞপ্তি</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <i class="fas fa-chart-pie fa-3x text-info mb-3"></i>
                <h5>আর্থিক রিপোর্ট</h5>
                <p class="small text-muted">আয়-ব্যয়ের বিস্তারিত রিপোর্ট</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
