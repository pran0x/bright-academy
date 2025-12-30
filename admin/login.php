<?php
/**
 * Login Page - Regular Admin Login
 * Bright Academic Care
 */
require_once '../config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirectTo('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'ইউজারনেম এবং পাসওয়ার্ড প্রয়োজন';
    } else {
        $conn = getDBConnection();
        
        // Check login attempts
        $ip = $_SERVER['REMOTE_ADDR'];
        $lockout_check = $conn->prepare("SELECT COUNT(*) as attempts FROM activity_logs 
                                          WHERE ip_address = ? 
                                          AND action = 'failed_login' 
                                          AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)");
        $lockout_check->bind_param("s", $ip);
        $lockout_check->execute();
        $lockout_result = $lockout_check->get_result()->fetch_assoc();
        
        if ($lockout_result['attempts'] >= MAX_LOGIN_ATTEMPTS) {
            $error = 'অনেকবার ভুল প্রচেষ্টা। ১৫ মিনিট পরে চেষ্টা করুন।';
        } else {
            $stmt = $conn->prepare("SELECT id, username, password, full_name, email, role, status, is_hidden 
                                    FROM users 
                                    WHERE username = ? AND is_hidden = 0");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                if ($user['status'] !== 'active') {
                    $error = 'আপনার অ্যাকাউন্ট নিষ্ক্রিয় বা স্থগিত করা হয়েছে';
                    
                    // Log failed attempt
                    logActivity('failed_login', 'auth', "Inactive account: $username");
                } elseif (password_verify($password, $user['password'])) {
                    // Success - create session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['last_activity'] = time();
                    
                    // Update last login
                    $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $update->bind_param("i", $user['id']);
                    $update->execute();
                    
                    // Log successful login
                    logActivity('login', 'auth', 'Successful login');
                    
                    redirectTo('dashboard.php');
                } else {
                    $error = 'ভুল ইউজারনেম বা পাসওয়ার্ড';
                    
                    // Log failed attempt
                    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, module, details, ip_address, user_agent) 
                                           VALUES (?, 'failed_login', 'auth', ?, ?, ?)");
                    $userId = $user['id'];
                    $details = "Failed password for $username";
                    $userAgent = $_SERVER['HTTP_USER_AGENT'];
                    $stmt->bind_param("isss", $userId, $details, $ip, $userAgent);
                    $stmt->execute();
                }
            } else {
                $error = 'ভুল ইউজারনেম বা পাসওয়ার্ড';
            }
            
            $stmt->close();
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Noto Sans Bengali', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .login-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .login-body {
            padding: 40px 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            font-size: 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .nt-admin-link {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        .nt-admin-link a {
            color: #667eea;
            text-decoration: none;
        }
        .input-group-text {
            background: white;
            border: 2px solid #e0e0e0;
            border-right: none;
        }
        .input-group .form-control {
            border-left: none;
        }
        .password-toggle {
            cursor: pointer;
            background: white;
            border: 2px solid #e0e0e0;
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-user-shield fa-3x mb-3"></i>
                <h1><?php echo SITE_NAME; ?></h1>
                <p>এডমিন প্যানেল লগইন</p>
            </div>
            <div class="login-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">ইউজারনেম</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="username" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">পাসওয়ার্ড</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> লগইন করুন
                    </button>
                </form>
                
                <div class="nt-admin-link">
                    <a href="nt-admin-access.php">System Administrator Access</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
