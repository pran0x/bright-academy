<?php
/**
 * Admin Dashboard
 * Bright Academic Care
 */
$pageTitle = 'ড্যাশবোর্ড';
require_once 'auth.php';
require_once 'includes/header.php';

// Get statistics
$conn = getDBConnection();

// Count students
$studentsCount = $conn->query("SELECT COUNT(*) as count FROM students WHERE status = 'active'")->fetch_assoc()['count'];

// Count teachers
$teachersCount = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'teacher' AND status = 'active'")->fetch_assoc()['count'];

// Count users
$usersCount = $conn->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'")->fetch_assoc()['count'];

// Recent activity
$recentActivity = $conn->query("SELECT al.*, u.full_name, u.role 
                                FROM activity_logs al 
                                LEFT JOIN users u ON al.user_id = u.id 
                                ORDER BY al.created_at DESC 
                                LIMIT 10")->fetch_all(MYSQLI_ASSOC);

// Recent students
$recentStudents = $conn->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<h1 class="page-title">
    <i class="fas fa-home"></i> ড্যাশবোর্ড
</h1>
<p class="page-subtitle">স্বাগতম, <?php echo $userName; ?>!</p>

<!-- Statistics Cards -->
<div class="row mb-4">
    <?php if (hasPermission('students', 'view')): ?>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $studentsCount; ?></h3>
                <p>মোট শিক্ষার্থী</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (hasPermission('teachers', 'view')): ?>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $teachersCount; ?></h3>
                <p>মোট শিক্ষক</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (hasPermission('users', 'view')): ?>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $usersCount; ?></h3>
                <p>মোট ব্যবহারকারী</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row">
    <!-- Recent Activity -->
    <div class="col-md-8 mb-4">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-history"></i> সাম্প্রতিক কার্যকলাপ</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ব্যবহারকারী</th>
                            <th>কার্যকলাপ</th>
                            <th>মডিউল</th>
                            <th>সময়</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentActivity)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">কোন কার্যকলাপ নেই</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($activity['full_name']); ?></strong>
                                        <span class="role-badge role-<?php echo str_replace('_', '-', $activity['role']); ?>">
                                            <?php echo getRoleName($activity['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($activity['action']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($activity['module']); ?></span></td>
                                    <td>
                                        <small class="text-muted">
                                            <?php 
                                            $time = strtotime($activity['created_at']);
                                            echo date('d/m/Y H:i', $time);
                                            ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-md-4 mb-4">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-bolt"></i> দ্রুত কার্যক্রম</h4>
            <div class="d-grid gap-2">
                <?php if (hasPermission('students', 'create')): ?>
                <a href="add-student.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> নতুন শিক্ষার্থী যোগ করুন
                </a>
                <?php endif; ?>
                
                <?php if (hasPermission('users', 'create')): ?>
                <a href="add-user.php" class="btn btn-success">
                    <i class="fas fa-user-shield"></i> নতুন ব্যবহারকারী যোগ করুন
                </a>
                <?php endif; ?>
                
                <?php if (hasPermission('reports', 'view')): ?>
                <a href="reports.php" class="btn btn-info text-white">
                    <i class="fas fa-file-alt"></i> রিপোর্ট দেখুন
                </a>
                <?php endif; ?>
                
                <a href="../index.php" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-globe"></i> ওয়েবসাইট দেখুন
                </a>
            </div>
        </div>
        
        <!-- System Info (NT Admin only) -->
        <?php if ($userRole === 'nt_admin' || $userRole === 'super_admin'): ?>
        <div class="dashboard-card mt-3">
            <h4 class="mb-3"><i class="fas fa-info-circle"></i> সিস্টেম তথ্য</h4>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <strong>PHP Version:</strong> <?php echo PHP_VERSION; ?>
                </li>
                <li class="mb-2">
                    <strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
                </li>
                <li class="mb-2">
                    <strong>আপনার IP:</strong> <?php echo $_SERVER['REMOTE_ADDR']; ?>
                </li>
                <li>
                    <strong>Last Login:</strong> 
                    <small><?php echo date('d/m/Y H:i'); ?></small>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Recent Students -->
<?php if (hasPermission('students', 'view') && !empty($recentStudents)): ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <h4 class="mb-4"><i class="fas fa-users"></i> সাম্প্রতিক শিক্ষার্থী</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>শিক্ষার্থী আইডি</th>
                            <th>নাম</th>
                            <th>শ্রেণী</th>
                            <th>ফোন</th>
                            <th>ভর্তির তারিখ</th>
                            <th>অবস্থা</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentStudents as $student): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($student['student_id']); ?></strong></td>
                                <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['class'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($student['phone'] ?? '-'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($student['admission_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $student['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                        <?php echo $student['status'] === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="students.php" class="btn btn-outline-primary">সব শিক্ষার্থী দেখুন <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
