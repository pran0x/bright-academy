<?php
/**
 * User Management Page
 * Manage admin users with role-based permissions
 */
$pageTitle = 'ব্যবহারকারী ব্যবস্থাপনা';
require_once 'auth.php';

// Check permission
if (!hasPermission('users', 'view')) {
    showAlert('আপনার এই পেজে প্রবেশের অনুমতি নেই', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

// Get all users (exclude hidden NT admin for non-NT admins)
$conn = getDBConnection();
if ($userRole === 'nt_admin') {
    $users = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
} else {
    $users = $conn->query("SELECT * FROM users WHERE is_hidden = 0 ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            <i class="fas fa-users"></i> ব্যবহারকারী ব্যবস্থাপনা
        </h1>
        <p class="page-subtitle">সকল ব্যবহারকারীর তালিকা ও ব্যবস্থাপনা</p>
    </div>
    <?php if (hasPermission('users', 'create')): ?>
    <a href="add-user.php" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> নতুন ব্যবহারকারী
    </a>
    <?php endif; ?>
</div>

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-hover datatable">
            <thead>
                <tr>
                    <th>আইডি</th>
                    <th>ইউজারনেম</th>
                    <th>পূর্ণ নাম</th>
                    <th>ইমেইল</th>
                    <th>ফোন</th>
                    <th>ভূমিকা</th>
                    <th>অবস্থা</th>
                    <th>শেষ লগইন</th>
                    <th>কার্যক্রম</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            <?php if ($user['is_hidden']): ?>
                                <i class="fas fa-eye-slash text-warning" title="Hidden"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo str_replace('_', '-', $user['role']); ?>">
                                <?php echo getRoleName($user['role']); ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $statusColors = [
                                'active' => 'success',
                                'inactive' => 'secondary',
                                'suspended' => 'danger'
                            ];
                            $statusLabels = [
                                'active' => 'সক্রিয়',
                                'inactive' => 'নিষ্ক্রিয়',
                                'suspended' => 'স্থগিত'
                            ];
                            ?>
                            <span class="badge bg-<?php echo $statusColors[$user['status']]; ?>">
                                <?php echo $statusLabels[$user['status']]; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['last_login']): ?>
                                <small><?php echo date('d/m/Y H:i', strtotime($user['last_login'])); ?></small>
                            <?php else: ?>
                                <small class="text-muted">কখনো নয়</small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['can_be_modified']): ?>
                                <?php if (hasPermission('users', 'edit')): ?>
                                <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php endif; ?>
                                
                                <?php if (hasPermission('users', 'delete') && $user['id'] !== $userId): ?>
                                <button onclick="confirmDelete(<?php echo $user['id']; ?>)" class="btn btn-sm btn-danger" title="মুছুন">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-lock"></i> Protected
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Role Distribution -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5><i class="fas fa-chart-pie"></i> ভূমিকা অনুযায়ী বিতরণ</h5>
            <?php
            $conn = getDBConnection();
            $roleStats = $conn->query("SELECT role, COUNT(*) as count FROM users WHERE is_hidden = 0 GROUP BY role")->fetch_all(MYSQLI_ASSOC);
            $conn->close();
            ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($roleStats as $stat): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="role-badge role-<?php echo str_replace('_', '-', $stat['role']); ?>">
                            <?php echo getRoleName($stat['role']); ?>
                        </span>
                        <span class="badge bg-primary rounded-pill"><?php echo $stat['count']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5><i class="fas fa-info-circle"></i> ভূমিকা বিবরণ</h5>
            <div class="small">
                <p><strong class="role-badge role-super-admin">সুপার এডমিন:</strong> সম্পূর্ণ সিস্টেম নিয়ন্ত্রণ (পরিবর্তনযোগ্য নয়)</p>
                <p><strong class="role-badge role-admin">এডমিন:</strong> ব্যবহারকারী ও কন্টেন্ট ম্যানেজমেন্ট</p>
                <p><strong class="role-badge role-moderator">মডারেটর:</strong> সীমিত কন্টেন্ট ম্যানেজমেন্ট</p>
                <p><strong class="role-badge role-teacher">শিক্ষক:</strong> মৌলিক শিক্ষণ সংক্রান্ত অ্যাক্সেস</p>
                <?php if ($userRole === 'nt_admin'): ?>
                <p><strong class="role-badge role-nt-admin">NT Administrator:</strong> System-level supreme access (hidden)</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    if (confirm('আপনি কি নিশ্চিত এই ব্যবহারকারীকে মুছে ফেলতে চান?')) {
        window.location.href = 'delete-user.php?id=' + userId;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
