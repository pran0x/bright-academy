<?php
/**
 * Edit Student
 */
$pageTitle = 'শিক্ষার্থী সম্পাদনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('students', 'update')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('students.php');
}


// Get student ID
$student_id = $_GET['id'] ?? 0;
$conn = getDBConnection();
// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    $conn->close();
    showAlert('শিক্ষার্থী খুঁজে পাওয়া যায়নি', 'error');
    redirectTo('students.php');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id_field = sanitizeInput($_POST['student_id']);
    $student_name = sanitizeInput($_POST['student_name']);
    $father_name = sanitizeInput($_POST['father_name']);
    $mother_name = sanitizeInput($_POST['mother_name']);
    $class = sanitizeInput($_POST['class']);
    $section = sanitizeInput($_POST['section']);
    $roll = sanitizeInput($_POST['roll']);
    $gender = sanitizeInput($_POST['gender']);
    $dob = trim($_POST['dob']);
    if ($dob === '') {
        $dob = null;
    }
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);
    $address = sanitizeInput($_POST['address']);
    $admission_date = sanitizeInput($_POST['admission_date']);
    $blood_group = sanitizeInput($_POST['blood_group']);
    $status = sanitizeInput($_POST['status']);
    $photo = $student['photo'] ?? null;
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
    // Validate required fields
    if (empty($student_id_field) || empty($student_name) || empty($father_name) || empty($mother_name) || empty($class) || empty($phone)) {
        showAlert('সকল প্রয়োজনীয় তথ্য পূরণ করুন', 'error');
    } else {
        // Check if student ID is already used by another student
        $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ? AND id != ?");
        $stmt->bind_param("si", $student_id_field, $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->fetch_assoc()) {
            showAlert('এই শিক্ষার্থী আইডি ইতিমধ্যে ব্যবহৃত হয়েছে', 'error');
        } else {
            // Update student
            $stmt = $conn->prepare("UPDATE students SET 
                student_id = ?, student_name = ?, father_name = ?, mother_name = ?, 
                class = ?, section = ?, roll = ?, gender = ?, dob = ?, 
                phone = ?, email = ?, address = ?, admission_date = ?, 
                blood_group = ?, status = ?, photo = ?, updated_at = NOW()
                WHERE id = ?");
            // If dob is null, use bind_param with 's' and pass null, else pass string
            $stmt->bind_param(
                "sssssssssssssssii",
                $student_id_field, $student_name, $father_name, $mother_name,
                $class, $section, $roll, $gender, $dob,
                $phone, $email, $address, $admission_date,
                $blood_group, $status, $photo, $student_id
            );
            if ($stmt->execute()) {
                logActivity('students', 'update', "শিক্ষার্থী আপডেট করা হয়েছে: $student_name ($student_id_field)");
                $conn->close();
                showAlert('শিক্ষার্থী সফলভাবে আপডেট করা হয়েছে', 'success');
                redirectTo('students.php');
            } else {
                showAlert('শিক্ষার্থী আপডেট করতে সমস্যা হয়েছে', 'error');
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-user-edit"></i> শিক্ষার্থী সম্পাদনা
    </h1>
    <p class="page-subtitle">শিক্ষার্থীর তথ্য আপডেট করুন</p>
</div>

<div class="dashboard-card">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ছবি</label>
                        <?php if (!empty($student['photo'])): ?>
                            <img src="<?php echo '../' . ltrim(htmlspecialchars($student['photo']), '/'); ?>" alt="Photo" class="img-thumbnail mb-2" style="max-width: 100px;">
                        <?php endif; ?>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">শিক্ষার্থী আইডি <span class="text-danger">*</span></label>
                <input type="text" name="student_id" class="form-control" value="<?php echo htmlspecialchars($student['student_id'] ?? ''); ?>" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">শিক্ষার্থীর নাম <span class="text-danger">*</span></label>
                <input type="text" name="student_name" class="form-control" value="<?php echo htmlspecialchars($student['student_name'] ?? ''); ?>" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">পিতার নাম <span class="text-danger">*</span></label>
                <input type="text" name="father_name" class="form-control" value="<?php echo htmlspecialchars($student['father_name'] ?? ''); ?>" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">মাতার নাম <span class="text-danger">*</span></label>
                <input type="text" name="mother_name" class="form-control" value="<?php echo htmlspecialchars($student['mother_name'] ?? ''); ?>" required>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">শ্রেণী <span class="text-danger">*</span></label>
                <select name="class" class="form-control" required>
                    <option value="">শ্রেণী নির্বাচন করুন</option>
                    <option value="Six" <?php echo ($student['class'] ?? '') == 'Six' ? 'selected' : ''; ?>>ষষ্ঠ শ্রেণী</option>
                    <option value="Seven" <?php echo ($student['class'] ?? '') == 'Seven' ? 'selected' : ''; ?>>সপ্তম শ্রেণী</option>
                    <option value="Eight" <?php echo ($student['class'] ?? '') == 'Eight' ? 'selected' : ''; ?>>অষ্টম শ্রেণী</option>
                    <option value="Nine" <?php echo ($student['class'] ?? '') == 'Nine' ? 'selected' : ''; ?>>নবম শ্রেণী</option>
                    <option value="Ten" <?php echo ($student['class'] ?? '') == 'Ten' ? 'selected' : ''; ?>>দশম শ্রেণী</option>
                </select>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">বিভাগ</label>
                <input type="text" name="section" class="form-control" value="<?php echo htmlspecialchars($student['section'] ?? ''); ?>" placeholder="যেমন: A, B, C">
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">রোল নম্বর</label>
                <input type="text" name="roll" class="form-control" value="<?php echo htmlspecialchars($student['roll'] ?? ''); ?>">
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">লিঙ্গ</label>
                <select name="gender" class="form-control">
                    <option value="">নির্বাচন করুন</option>
                    <option value="Male" <?php echo ($student['gender'] ?? '') == 'Male' ? 'selected' : ''; ?>>পুরুষ</option>
                    <option value="Female" <?php echo ($student['gender'] ?? '') == 'Female' ? 'selected' : ''; ?>>মহিলা</option>
                    <option value="Other" <?php echo ($student['gender'] ?? '') == 'Other' ? 'selected' : ''; ?>>অন্যান্য</option>
                </select>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">জন্ম তারিখ</label>
                <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($student['dob'] ?? ''); ?>">
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">রক্তের গ্রুপ</label>
                <select name="blood_group" class="form-control">
                    <option value="">নির্বাচন করুন</option>
                    <option value="A+" <?php echo ($student['blood_group'] ?? '') == 'A+' ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo ($student['blood_group'] ?? '') == 'A-' ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo ($student['blood_group'] ?? '') == 'B+' ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo ($student['blood_group'] ?? '') == 'B-' ? 'selected' : ''; ?>>B-</option>
                    <option value="O+" <?php echo ($student['blood_group'] ?? '') == 'O+' ? 'selected' : ''; ?>>O+</option>
                    <option value="O-" <?php echo ($student['blood_group'] ?? '') == 'O-' ? 'selected' : ''; ?>>O-</option>
                    <option value="AB+" <?php echo ($student['blood_group'] ?? '') == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo ($student['blood_group'] ?? '') == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">মোবাইল নম্বর <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">ইমেইল</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">ভর্তির তারিখ</label>
                <input type="date" name="admission_date" class="form-control" value="<?php echo htmlspecialchars($student['admission_date'] ?? ''); ?>">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">স্ট্যাটাস</label>
                <select name="status" class="form-control">
                    <option value="active" <?php echo ($student['status'] ?? '') == 'active' ? 'selected' : ''; ?>>সক্রিয়</option>
                    <option value="inactive" <?php echo ($student['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>নিষ্ক্রিয়</option>
                </select>
            </div>
            
            <div class="col-12 mb-3">
                <label class="form-label">ঠিকানা</label>
                <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($student['address'] ?? ''); ?></textarea>
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> সংরক্ষণ করুন
            </button>
            <a href="students.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> বাতিল
            </a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
