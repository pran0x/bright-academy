<?php
/**
 * Add New Student
 */
$pageTitle = 'নতুন শিক্ষার্থী যোগ করুন';
require_once 'auth.php';

// Check permission
if (!hasPermission('students', 'create')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = sanitizeInput($_POST['student_id']);
    $student_name = sanitizeInput($_POST['student_name']);
    $father_name = sanitizeInput($_POST['father_name']);
    $mother_name = sanitizeInput($_POST['mother_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $class = sanitizeInput($_POST['class']);
    $section = sanitizeInput($_POST['section']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);
    $address = sanitizeInput($_POST['address']);
    $admission_date = $_POST['admission_date'];
    $photo = null;
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $filename = uniqid('student_', true) . '.' . $ext;
            $target = '../uploads/' . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $photo = 'uploads/' . $filename;
            }
        }
    }
    // Validation
    if (empty($student_id) || empty($student_name) || empty($admission_date)) {
        $error = 'শিক্ষার্থী আইডি, নাম এবং ভর্তির তারিখ প্রয়োজন';
    } else {
        $conn = getDBConnection();
        // Check if student ID exists
        $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'এই শিক্ষার্থী আইডি ইতিমধ্যে ব্যবহৃত হয়েছে';
        } else {
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO students (student_id, student_name, father_name, mother_name, dob, gender, class, section, phone, email, address, admission_date, photo, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssssi", $student_id, $student_name, $father_name, $mother_name, $dob, $gender, $class, $section, $phone, $email, $address, $admission_date, $photo, $userId);
            if ($stmt->execute()) {
                logActivity('students', 'create', "শিক্ষার্থী যোগ করা হয়েছে: $student_name ($student_id)");
                showAlert('নতুন শিক্ষার্থী সফলভাবে যোগ করা হয়েছে', 'success');
                redirectTo('students.php');
            } else {
                $error = 'শিক্ষার্থী যোগ করতে ব্যর্থ হয়েছে';
            }
        }
        $stmt->close();
        $conn->close();
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex align-items-center mb-4">
            <a href="students.php" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> ফিরে যান
            </a>
            <div>
                <h1 class="page-title mb-0">
                    <i class="fas fa-user-plus"></i> নতুন শিক্ষার্থী যোগ করুন
                </h1>
            </div>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="dashboard-card">
            <form method="POST" action="" enctype="multipart/form-data">
                <h5 class="mb-3"><i class="fas fa-user"></i> মৌলিক তথ্য</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ছবি</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">শিক্ষার্থী আইডি <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="student_id" required 
                               value="<?php echo $_POST['student_id'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-8 mb-3">
                        <label class="form-label">পূর্ণ নাম <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="student_name" required
                               value="<?php echo $_POST['student_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">পিতার নাম</label>
                        <input type="text" class="form-control" name="father_name"
                               value="<?php echo $_POST['father_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">মাতার নাম</label>
                        <input type="text" class="form-control" name="mother_name"
                               value="<?php echo $_POST['mother_name'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">জন্ম তারিখ</label>
                        <input type="date" class="form-control" name="dob"
                               value="<?php echo $_POST['dob'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">লিঙ্গ</label>
                        <select class="form-select" name="gender">
                            <option value="">নির্বাচন করুন</option>
                            <option value="male">ছেলে</option>
                            <option value="female">মেয়ে</option>
                            <option value="other">অন্যান্য</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ভর্তির তারিখ <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="admission_date" required
                               value="<?php echo $_POST['admission_date'] ?? date('Y-m-d'); ?>">
                    </div>
                </div>
                
                <hr class="my-4">
                <h5 class="mb-3"><i class="fas fa-school"></i> শিক্ষাগত তথ্য</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">শ্রেণী</label>
                        <select class="form-select" name="class">
                            <option value="">নির্বাচন করুন</option>
                            <option value="৬ষ্ঠ">৬ষ্ঠ শ্রেণী</option>
                            <option value="৭ম">৭ম শ্রেণী</option>
                            <option value="৮ম">৮ম শ্রেণী</option>
                            <option value="৯ম">৯ম শ্রেণী</option>
                            <option value="১০ম">১০ম শ্রেণী</option>
                            <option value="একাদশ">একাদশ শ্রেণী</option>
                            <option value="দ্বাদশ">দ্বাদশ শ্রেণী</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">শাখা/সেকশন</label>
                        <input type="text" class="form-control" name="section"
                               value="<?php echo $_POST['section'] ?? ''; ?>">
                    </div>
                </div>
                
                <hr class="my-4">
                <h5 class="mb-3"><i class="fas fa-address-book"></i> যোগাযোগের তথ্য</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ফোন নম্বর</label>
                        <input type="tel" class="form-control" name="phone"
                               value="<?php echo $_POST['phone'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ইমেইল</label>
                        <input type="email" class="form-control" name="email"
                               value="<?php echo $_POST['email'] ?? ''; ?>">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">ঠিকানা</label>
                        <textarea class="form-control" name="address" rows="3"><?php echo $_POST['address'] ?? ''; ?></textarea>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> সংরক্ষণ করুন
                    </button>
                    <a href="students.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
