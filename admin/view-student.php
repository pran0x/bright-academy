<?php
/**
 * View Student Details
 */
$pageTitle = 'শিক্ষার্থীর বিস্তারিত তথ্য';
require_once 'auth.php';

// Check permission
if (!hasPermission('students', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('students.php');
}


// Get student ID
$student_id = $_GET['id'] ?? 0;
$conn = getDBConnection();
// Fetch student data with creator info
$stmt = $conn->prepare("SELECT s.*, u.full_name as created_by_name FROM students s LEFT JOIN users u ON s.created_by = u.id WHERE s.id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$conn->close();

if (!$student) {
    showAlert('শিক্ষার্থী খুঁজে পাওয়া যায়নি', 'error');
    redirectTo('students.php');
}

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-user-graduate"></i> শিক্ষার্থীর বিস্তারিত তথ্য
        </h1>
        <p class="page-subtitle">সম্পূর্ণ তথ্য দেখুন</p>
    </div>
    <div>
        <?php if (hasPermission('students', 'update')): ?>
        <a href="edit-student.php?id=<?php echo $student['id']; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> সম্পাদনা
        </a>
        <?php endif; ?>
        <a href="students.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> ফিরে যান
        </a>
    </div>
</div>

<div class="row">
    <!-- Student Photo & Basic Info -->
    <div class="col-md-4">
        <div class="dashboard-card text-center">
            <?php if (!empty($student['photo'])): ?>
                <img src="<?php echo '../' . ltrim(htmlspecialchars($student['photo']), '/'); ?>" alt="ছাত্রের ছবি" class="img-thumbnail mb-3" style="max-width: 200px;">
            <?php else: ?>
                <div class="bg-light rounded mb-3 py-5">
                    <i class="fas fa-user-graduate fa-5x text-secondary"></i>
                </div>
            <?php endif; ?>
            
            <h4><?php echo htmlspecialchars($student['student_name'] ?? 'N/A'); ?></h4>
            <p class="text-muted mb-2">আইডি: <?php echo htmlspecialchars($student['student_id']); ?></p>
            
            <?php if ($student['status'] == 'active'): ?>
                <span class="badge bg-success">সক্রিয়</span>
            <?php else: ?>
                <span class="badge bg-danger">নিষ্ক্রিয়</span>
            <?php endif; ?>
            
            <hr>
            
            <div class="d-flex justify-content-around text-center">
                <div>
                    <h5><?php echo htmlspecialchars($student['class']); ?></h5>
                    <small class="text-muted">শ্রেণী</small>
                </div>
                <?php if (!empty($student['section'])): ?>
                <div>
                    <h5><?php echo htmlspecialchars($student['section']); ?></h5>
                    <small class="text-muted">বিভাগ</small>
                </div>
                <?php endif; ?>
                <?php if (!empty($student['roll'])): ?>
                <div>
                    <h5><?php echo htmlspecialchars($student['roll']); ?></h5>
                    <small class="text-muted">রোল</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Detailed Information -->
    <div class="col-md-8">
        <!-- Personal Information -->
        <div class="dashboard-card mb-3">
            <h5 class="mb-3"><i class="fas fa-user"></i> ব্যক্তিগত তথ্য</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">পিতার নাম</label>
                    <p class="mb-0"><?php echo htmlspecialchars($student['father_name']); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">মাতার নাম</label>
                    <p class="mb-0"><?php echo htmlspecialchars($student['mother_name']); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">জন্ম তারিখ</label>
                    <p class="mb-0"><?php echo !empty($student['dob']) ? date('d M Y', strtotime($student['dob'])) : 'N/A'; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">লিঙ্গ</label>
                    <p class="mb-0">
                        <?php 
                        if ($student['gender'] == 'Male') echo 'পুরুষ';
                        elseif ($student['gender'] == 'Female') echo 'মহিলা';
                        else echo $student['gender'];
                        ?>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">রক্তের গ্রুপ</label>
                    <p class="mb-0"><?php echo !empty($student['blood_group']) ? htmlspecialchars($student['blood_group']) : 'N/A'; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="dashboard-card mb-3">
            <h5 class="mb-3"><i class="fas fa-address-book"></i> যোগাযোগের তথ্য</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">মোবাইল নম্বর</label>
                    <p class="mb-0"><i class="fas fa-phone text-primary"></i> <?php echo htmlspecialchars($student['phone']); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">ইমেইল</label>
                    <p class="mb-0"><i class="fas fa-envelope text-primary"></i> <?php echo !empty($student['email']) ? htmlspecialchars($student['email']) : 'N/A'; ?></p>
                </div>
                <div class="col-12 mb-3">
                    <label class="text-muted small">ঠিকানা</label>
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo !empty($student['address']) ? htmlspecialchars($student['address']) : 'N/A'; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Academic Information -->
        <div class="dashboard-card mb-3">
            <h5 class="mb-3"><i class="fas fa-graduation-cap"></i> একাডেমিক তথ্য</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">ভর্তির তারিখ</label>
                    <p class="mb-0"><?php echo !empty($student['admission_date']) ? date('d M Y', strtotime($student['admission_date'])) : 'N/A'; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">যোগদানকারী</label>
                    <p class="mb-0"><?php echo htmlspecialchars($student['created_by_name'] ?? 'Unknown'); ?></p>
                </div>
            </div>
        </div>
        
        <!-- System Information -->
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-info-circle"></i> সিস্টেম তথ্য</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">তৈরির তারিখ</label>
                    <p class="mb-0"><?php echo date('d M Y H:i', strtotime($student['created_at'])); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">সর্বশেষ আপডেট</label>
                    <p class="mb-0"><?php echo date('d M Y H:i', strtotime($student['updated_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 class="mb-3"><i class="fas fa-tasks"></i> দ্রুত অ্যাকশন</h5>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-outline-primary" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-calendar-check"></i> উপস্থিতি দেখুন
                </button>
                <button class="btn btn-outline-success" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-chart-bar"></i> ফলাফল দেখুন
                </button>
                <button class="btn btn-outline-info" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-dollar-sign"></i> ফি রেকর্ড
                </button>
                <button class="btn btn-outline-warning" onclick="alert('এই ফিচারটি শীঘ্রই আসছে')">
                    <i class="fas fa-print"></i> প্রোফাইল প্রিন্ট
                </button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
