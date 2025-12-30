<?php
/**
 * System Logs - NT Admin Only
 */
$pageTitle = 'System Activity Logs';
require_once 'auth.php';

// Check if user is NT admin or super admin
if ($userRole !== 'nt_admin' && $userRole !== 'super_admin') {
    showAlert('Unauthorized access', 'error');
    redirectTo('dashboard.php');
}

require_once 'includes/header.php';

// Get logs with filters
$filter_user = $_GET['user'] ?? '';
$filter_module = $_GET['module'] ?? '';
$filter_action = $_GET['action'] ?? '';
$limit = $_GET['limit'] ?? 100;

$conn = getDBConnection();

$query = "SELECT al.*, u.username, u.full_name, u.role 
          FROM activity_logs al 
          LEFT JOIN users u ON al.user_id = u.id 
          WHERE 1=1";

$params = [];
$types = '';

if (!empty($filter_user)) {
    $query .= " AND u.username LIKE ?";
    $params[] = "%$filter_user%";
    $types .= 's';
}

if (!empty($filter_module)) {
    $query .= " AND al.module = ?";
    $params[] = $filter_module;
    $types .= 's';
}

if (!empty($filter_action)) {
    $query .= " AND al.action LIKE ?";
    $params[] = "%$filter_action%";
    $types .= 's';
}

$query .= " ORDER BY al.created_at DESC LIMIT ?";
$params[] = (int)$limit;
$types .= 'i';

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$logs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get unique modules for filter
$modules = $conn->query("SELECT DISTINCT module FROM activity_logs ORDER BY module")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<h1 class="page-title">
    <i class="fas fa-terminal"></i> System Activity Logs
</h1>
<p class="page-subtitle">Complete system activity tracking and monitoring</p>

<!-- Filters -->
<div class="dashboard-card mb-4">
    <form method="GET" action="" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="user" placeholder="Search by username" 
                   value="<?php echo htmlspecialchars($filter_user); ?>">
        </div>
        
        <div class="col-md-3">
            <label class="form-label">Module</label>
            <select class="form-select" name="module">
                <option value="">All Modules</option>
                <?php foreach ($modules as $mod): ?>
                    <option value="<?php echo $mod['module']; ?>" <?php echo $filter_module === $mod['module'] ? 'selected' : ''; ?>>
                        <?php echo $mod['module']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-md-3">
            <label class="form-label">Action</label>
            <input type="text" class="form-control" name="action" placeholder="Search action" 
                   value="<?php echo htmlspecialchars($filter_action); ?>">
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Limit</label>
            <select class="form-select" name="limit">
                <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                <option value="500" <?php echo $limit == 500 ? 'selected' : ''; ?>>500</option>
                <option value="1000" <?php echo $limit == 1000 ? 'selected' : ''; ?>>1000</option>
            </select>
        </div>
        
        <div class="col-md-1">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Details</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No logs found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><small><?php echo $log['id']; ?></small></td>
                            <td><small><?php echo date('d/m/Y H:i:s', strtotime($log['created_at'])); ?></small></td>
                            <td>
                                <strong><?php echo htmlspecialchars($log['username'] ?? 'Unknown'); ?></strong>
                                <br><small class="text-muted"><?php echo htmlspecialchars($log['full_name'] ?? ''); ?></small>
                            </td>
                            <td>
                                <span class="role-badge role-<?php echo str_replace('_', '-', $log['role']); ?>">
                                    <?php echo $log['role']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo strpos($log['action'], 'delete') !== false ? 'danger' : 
                                        (strpos($log['action'], 'create') !== false ? 'success' : 
                                        (strpos($log['action'], 'update') !== false ? 'warning' : 'info')); 
                                ?>">
                                    <?php echo htmlspecialchars($log['action']); ?>
                                </span>
                            </td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($log['module']); ?></span></td>
                            <td><small><?php echo htmlspecialchars($log['details'] ?? '-'); ?></small></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($log['ip_address']); ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-3 text-end">
        <small class="text-muted">Showing <?php echo count($logs); ?> logs</small>
    </div>
</div>

<!-- Log Statistics -->
<div class="row mt-4">
    <?php
    $conn = getDBConnection();
    $todayLogs = $conn->query("SELECT COUNT(*) as count FROM activity_logs WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];
    $weekLogs = $conn->query("SELECT COUNT(*) as count FROM activity_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['count'];
    $monthLogs = $conn->query("SELECT COUNT(*) as count FROM activity_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch_assoc()['count'];
    $totalLogs = $conn->query("SELECT COUNT(*) as count FROM activity_logs")->fetch_assoc()['count'];
    $conn->close();
    ?>
    
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-info"><?php echo $todayLogs; ?></h3>
            <p class="mb-0">Today's Logs</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-primary"><?php echo $weekLogs; ?></h3>
            <p class="mb-0">Last 7 Days</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-warning"><?php echo $monthLogs; ?></h3>
            <p class="mb-0">Last 30 Days</p>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="dashboard-card text-center">
            <h3 class="text-success"><?php echo $totalLogs; ?></h3>
            <p class="mb-0">Total Logs</p>
        </div>
    </div>
</div>

<style>
    .table-sm td, .table-sm th {
        font-size: 0.875rem;
        padding: 0.5rem;
    }
</style>

<?php require_once 'includes/footer.php'; ?>
