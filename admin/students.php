<?php
/**
 * Student Management
 */
$pageTitle = 'শিক্ষার্থী ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('students', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

// Get all students with search
$search = $_GET['search'] ?? '';
$conn = getDBConnection();

if (!empty($search)) {
    $searchTerm = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id LIKE ? OR student_name LIKE ? OR phone LIKE ? ORDER BY created_at DESC");
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $students = $conn->query("SELECT * FROM students ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-user-graduate"></i> শিক্ষার্থী ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">সকল শিক্ষার্থীর তালিকা ও ব্যবস্থাপনা</p>
    </div>
    <div>
        <?php if (hasPermission('students', 'create')): ?>
        <a href="add-student.php" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> নতুন শিক্ষার্থী
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Search Bar -->
<div class="dashboard-card mb-4">
    <form method="GET" action="" class="row g-3">
        <div class="col-md-10">
            <input type="text" class="form-control" name="search" placeholder="শিক্ষার্থী আইডি, নাম বা ফোন দিয়ে খুঁজুন..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> খুঁজুন
            </button>
        </div>
    </form>
</div>

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-hover datatable">
            <thead>
                <tr>
                    <th>আইডি</th>
                    <th>ছবি</th>
                    <th>নাম</th>
                    <th>শ্রেণী</th>
                    <th>ফোন</th>
                    <th>ইমেইল</th>
                    <th>ভর্তির তারিখ</th>
                    <th>অবস্থা</th>
                    <th>কার্যক্রম</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            কোন শিক্ষার্থী পাওয়া যায়নি
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($student['student_id']); ?></strong></td>
                            <td>
                                <?php if (!empty($student['photo'])): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($student['photo']); ?>" alt="Photo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <?php echo mb_substr($student['student_name'], 0, 1, 'UTF-8'); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['class'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($student['phone'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($student['email'] ?? '-'); ?></td>
                            <td><?php echo !empty($student['admission_date']) ? date('d/m/Y', strtotime($student['admission_date'])) : '-'; ?></td>
                            <td>
                                <?php
                                $statusColors = [
                                    'active' => 'success',
                                    'inactive' => 'secondary',
                                    'graduated' => 'info'
                                ];
                                $statusLabels = [
                                    'active' => 'সক্রিয়',
                                    'inactive' => 'নিষ্ক্রিয়',
                                    'graduated' => 'সমাপ্ত'
                                ];
                                ?>
                                <span class="badge bg-<?php echo $statusColors[$student['status']]; ?>">
                                    <?php echo $statusLabels[$student['status']]; ?>
                                </span>
                            </td>
                            <td>
                                <a href="view-student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-info" title="বিস্তারিত">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if (hasPermission('students', 'edit')): ?>
                                <a href="edit-student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php endif; ?>
                                
                                <?php if (hasPermission('students', 'delete')): ?>
                                <button onclick="confirmDelete(<?php echo $student['id']; ?>)" class="btn btn-sm btn-danger" title="মুছুন">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-primary"><?php echo count(array_filter($students, fn($s) => $s['status'] === 'active')); ?></h3>
            <p class="mb-0">সক্রিয় শিক্ষার্থী</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-secondary"><?php echo count(array_filter($students, fn($s) => $s['status'] === 'inactive')); ?></h3>
            <p class="mb-0">নিষ্ক্রিয় শিক্ষার্থী</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-info"><?php echo count(array_filter($students, fn($s) => $s['status'] === 'graduated')); ?></h3>
            <p class="mb-0">সমাপ্ত শিক্ষার্থী</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-success"><?php echo count($students); ?></h3>
            <p class="mb-0">মোট শিক্ষার্থী</p>
        </div>
    </div>
</div>

<script>
function confirmDelete(studentId) {
    if (confirm('আপনি কি নিশ্চিত এই শিক্ষার্থীকে মুছে ফেলতে চান?')) {
        window.location.href = 'delete-student.php?id=' + studentId;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
