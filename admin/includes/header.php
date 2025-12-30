<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Dashboard'; ?> - <?php echo SITE_NAME; ?></title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom Admin CSS -->
    <style>
        * {
            font-family: 'Noto Sans Bengali', sans-serif;
        }
        
        :root {
            --sidebar-width: 260px;
            --header-height: 60px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        
        body {
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar-header {
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
        }
        
        .sidebar-header h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-header small {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .sidebar.collapsed .sidebar-header h4,
        .sidebar.collapsed .sidebar-header small {
            display: none;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .menu-item:hover {
            background: var(--sidebar-hover);
            color: white;
            padding-left: 25px;
        }
        
        .menu-item.active {
            background: var(--primary-color);
            border-left: 4px solid white;
        }
        
        .menu-item i {
            width: 30px;
            font-size: 18px;
        }
        
        .menu-item span {
            margin-left: 10px;
        }
        
        .sidebar.collapsed .menu-item span {
            display: none;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }
        
        /* Header */
        .top-header {
            background: white;
            height: var(--header-height);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #2c3e50;
            cursor: pointer;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }
        
        .dropdown-menu {
            font-size: 14px;
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .stat-content h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
        }
        
        .stat-content p {
            margin: 0;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        /* Role Badge */
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .role-super-admin { background: #e74c3c; color: white; }
        .role-admin { background: #3498db; color: white; }
        .role-moderator { background: #f39c12; color: white; }
        .role-teacher { background: #2ecc71; color: white; }
        .role-nt-admin { background: #000; color: #0f0; border: 1px solid #0f0; }
        
        /* Content Area */
        .content-area {
            padding: 30px;
            min-height: calc(100vh - var(--header-height));
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
        }
        
        /* Tables */
        .table thead {
            background: #f8f9fa;
        }
        
        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: var(--sidebar-bg);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><?php echo SITE_NAME; ?></h4>
            <small>এডমিন প্যানেল</small>
        </div>
        
        <div class="sidebar-menu">
            <a href="dashboard.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>ড্যাশবোর্ড</span>
            </a>
            
            <?php if (hasPermission('students', 'view')): ?>
            <a href="students.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'students.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-graduate"></i>
                <span>শিক্ষার্থী</span>
            </a>
            <?php endif; ?>
            
            <?php if (hasPermission('teachers', 'view')): ?>
            <a href="teachers.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'teachers.php' ? 'active' : ''; ?>">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>শিক্ষক</span>
            </a>
            <?php endif; ?>
            
            <?php if (hasPermission('courses', 'view')): ?>
            <a href="courses.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'courses.php' ? 'active' : ''; ?>">
                <i class="fas fa-book"></i>
                <span>কোর্স</span>
            </a>
            <?php endif; ?>
            
            <?php if (hasPermission('users', 'view')): ?>
            <a href="users.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>ব্যবহারকারী</span>
            </a>
            <?php endif; ?>
            
            <?php if (hasPermission('reports', 'view')): ?>
            <a href="reports.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                <span>রিপোর্ট</span>
            </a>
            <?php endif; ?>
            
            <?php if (hasPermission('settings', 'view')): ?>
            <a href="settings.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i>
                <span>সেটিংস</span>
            </a>
            <?php endif; ?>
            
            <?php if ($userRole === 'nt_admin'): ?>
            <a href="system-logs.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'system-logs.php' ? 'active' : ''; ?>">
                <i class="fas fa-terminal"></i>
                <span>System Logs</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="user-info">
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                        </div>
                        <span class="ms-2"><?php echo $userName; ?></span>
                        <span class="role-badge role-<?php echo str_replace('_', '-', $userRole); ?>">
                            <?php echo getRoleName($userRole); ?>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> প্রোফাইল</a></li>
                        <li><a class="dropdown-item" href="change-password.php"><i class="fas fa-key"></i> পাসওয়ার্ড পরিবর্তন</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> লগআউট</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            <?php displayAlert(); ?>
