<?php
/**
 * Reports and Analytics
 */
$pageTitle = 'রিপোর্ট ও বিশ্লেষণ';
require_once 'auth.php';

// Check permission
if (!hasPermission('reports', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

$conn = getDBConnection();

// Get statistics
$totalStudents = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$activeStudents = $conn->query("SELECT COUNT(*) as count FROM students WHERE status = 'active'")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch_assoc()['count'];

// Students by class
$studentsByClass = $conn->query("SELECT class, COUNT(*) as count FROM students WHERE status = 'active' GROUP BY class ORDER BY class")->fetch_all(MYSQLI_ASSOC);

// Students by month (last 6 months)
$studentsByMonth = $conn->query("SELECT DATE_FORMAT(admission_date, '%Y-%m') as month, COUNT(*) as count 
                                 FROM students 
                                 WHERE admission_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                                 GROUP BY month 
                                 ORDER BY month DESC")->fetch_all(MYSQLI_ASSOC);

// Recent admissions
$recentAdmissions = $conn->query("SELECT * FROM students ORDER BY admission_date DESC LIMIT 10")->fetch_all(MYSQLI_ASSOC);

// User activity by role
$usersByRole = $conn->query("SELECT role, COUNT(*) as count FROM users WHERE status = 'active' GROUP BY role")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<h1 class="page-title">
    <i class="fas fa-chart-bar"></i> রিপোর্ট ও বিশ্লেষণ
</h1>
<p class="page-subtitle">প্রতিষ্ঠানের বিভিন্ন পরিসংখ্যান ও রিপোর্ট</p>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalStudents; ?></h3>
                <p>মোট শিক্ষার্থী</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $activeStudents; ?></h3>
                <p>সক্রিয় শিক্ষার্থী</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalUsers; ?></h3>
                <p>সক্রিয় ব্যবহারকারী</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalStudents > 0 ? round(($activeStudents/$totalStudents)*100) : 0; ?>%</h3>
                <p>সক্রিয়তার হার</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Students by Class -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4"><i class="fas fa-chart-pie"></i> শ্রেণী অনুযায়ী শিক্ষার্থী</h5>
            <?php if (empty($studentsByClass)): ?>
                <p class="text-muted text-center">কোন ডেটা নেই</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>শ্রেণী</th>
                                <th>শিক্ষার্থী সংখ্যা</th>
                                <th>শতাংশ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($studentsByClass as $class): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($class['class'] ?: 'অনির্ধারিত'); ?></strong></td>
                                    <td><?php echo $class['count']; ?></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <?php $percentage = ($class['count']/$activeStudents)*100; ?>
                                            <div class="progress-bar" style="width: <?php echo $percentage; ?>%">
                                                <?php echo round($percentage); ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Admissions -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4"><i class="fas fa-clock"></i> সাম্প্রতিক ভর্তি</h5>
            <?php if (empty($recentAdmissions)): ?>
                <p class="text-muted text-center">কোন ডেটা নেই</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>নাম</th>
                                <th>শ্রেণী</th>
                                <th>তারিখ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentAdmissions as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['class'] ?: '-'); ?></td>
                                    <td><small><?php echo date('d/m/Y', strtotime($student['admission_date'])); ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Monthly Admissions -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4"><i class="fas fa-calendar-alt"></i> মাসিক ভর্তি (শেষ ৬ মাস)</h5>
            <?php if (empty($studentsByMonth)): ?>
                <p class="text-muted text-center">কোন ডেটা নেই</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>মাস</th>
                                <th>ভর্তি সংখ্যা</th>
                                <th>গ্রাফ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $maxCount = max(array_column($studentsByMonth, 'count'));
                            foreach ($studentsByMonth as $month): 
                            ?>
                                <tr>
                                    <td><strong><?php echo date('F Y', strtotime($month['month'] . '-01')); ?></strong></td>
                                    <td><?php echo $month['count']; ?></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <?php $width = ($month['count']/$maxCount)*100; ?>
                                            <div class="progress-bar bg-success" style="width: <?php echo $width; ?>%"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Users by Role -->
    <div class="col-md-6 mb-4">
        <div class="dashboard-card">
            <h5 class="mb-4"><i class="fas fa-user-tag"></i> ভূমিকা অনুযায়ী ব্যবহারকারী</h5>
            <?php if (empty($usersByRole)): ?>
                <p class="text-muted text-center">কোন ডেটা নেই</p>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($usersByRole as $roleData): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="role-badge role-<?php echo str_replace('_', '-', $roleData['role']); ?>">
                                <?php echo getRoleName($roleData['role']); ?>
                            </span>
                            <span class="badge bg-primary rounded-pill"><?php echo $roleData['count']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Export Options -->
<div class="dashboard-card">
    <h5 class="mb-3"><i class="fas fa-download"></i> রিপোর্ট এক্সপোর্ট</h5>
    <div class="row">
        <div class="col-md-4 mb-2">
            <button class="btn btn-outline-success w-100" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                <i class="fas fa-file-excel"></i> Excel এ এক্সপোর্ট
            </button>
        </div>
        <div class="col-md-4 mb-2">
            <button class="btn btn-outline-danger w-100" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                <i class="fas fa-file-pdf"></i> PDF এ এক্সপোর্ট
            </button>
        </div>
        <div class="col-md-4 mb-2">
            <button class="btn btn-outline-primary w-100" onclick="window.print()">
                <i class="fas fa-print"></i> প্রিন্ট করুন
            </button>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
