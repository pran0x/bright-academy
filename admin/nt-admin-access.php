<?php
/**
 * NT Administrator Access Portal (Hidden)
 * Requires special access code
 */
require_once '../config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirectTo('dashboard.php');
}

$error = '';
$showLoginForm = false;

// Check if access code is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['access_code'])) {
        // Verify access code
        $access_code = $_POST['access_code'];
        
        if ($access_code === NT_ADMIN_ACCESS_CODE) {
            $showLoginForm = true;
            $_SESSION['nt_access_granted'] = true;
        } else {
            $error = 'Invalid access code. This incident will be logged.';
            
            // Log unauthorized access attempt
            $conn = getDBConnection();
            $ip = $_SERVER['REMOTE_ADDR'];
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, module, details, ip_address, user_agent) 
                                   VALUES (0, 'unauthorized_access', 'nt_admin', ?, ?, ?)");
            $details = "Failed NT Admin access code attempt";
            $stmt->bind_param("sss", $details, $ip, $userAgent);
            $stmt->execute();
            $conn->close();
        }
    } elseif (isset($_POST['username']) && isset($_SESSION['nt_access_granted'])) {
        // Process NT Admin login
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($password)) {
            $error = 'Username and password required';
            $showLoginForm = true;
        } else {
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT id, username, password, full_name, email, role, status 
                                    FROM users 
                                    WHERE username = ? AND role = 'nt_admin'");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password'])) {
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
                    
                    // Log NT admin login
                    logActivity('nt_admin_login', 'auth', 'NT Administrator logged in');
                    
                    unset($_SESSION['nt_access_granted']);
                    redirectTo('dashboard.php');
                } else {
                    $error = 'Invalid credentials';
                    $showLoginForm = true;
                    
                    // Log failed attempt
                    logActivity('failed_nt_login', 'auth', "Failed NT Admin login attempt for: $username");
                }
            } else {
                $error = 'Invalid credentials';
                $showLoginForm = true;
            }
            
            $stmt->close();
            $conn->close();
        }
    }
} elseif (isset($_SESSION['nt_access_granted'])) {
    $showLoginForm = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Administrator Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Courier New', monospace;
        }
        body {
            background: #000;
            color: #0f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .terminal-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }
        .terminal-card {
            background: #1a1a1a;
            border: 2px solid #0f0;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.3);
            overflow: hidden;
        }
        .terminal-header {
            background: #0a0a0a;
            padding: 10px 20px;
            border-bottom: 1px solid #0f0;
            display: flex;
            align-items: center;
        }
        .terminal-header .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .dot.red { background: #ff5f56; }
        .dot.yellow { background: #ffbd2e; }
        .dot.green { background: #27c93f; }
        .terminal-body {
            padding: 30px;
        }
        .terminal-title {
            color: #0f0;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.5; }
        }
        .form-control {
            background: #000;
            border: 1px solid #0f0;
            color: #0f0;
            border-radius: 5px;
            padding: 10px;
            font-family: 'Courier New', monospace;
        }
        .form-control:focus {
            background: #000;
            border-color: #0f0;
            color: #0f0;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }
        .form-control::placeholder {
            color: #0a0;
        }
        .btn-terminal {
            background: #0a0;
            border: 1px solid #0f0;
            color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-terminal:hover {
            background: #0f0;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.8);
        }
        .alert-terminal {
            background: #1a0000;
            border: 1px solid #f00;
            color: #f00;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #0a0;
            text-decoration: none;
            font-size: 12px;
        }
        .back-link a:hover {
            color: #0f0;
        }
        .prompt {
            color: #0f0;
            margin-right: 10px;
        }
        label {
            color: #0f0;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .warning-text {
            color: #ff0;
            font-size: 11px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="terminal-container">
        <div class="terminal-card">
            <div class="terminal-header">
                <div class="dot red"></div>
                <div class="dot yellow"></div>
                <div class="dot green"></div>
                <span style="color: #0f0; margin-left: 10px; font-size: 12px;">NT ADMINISTRATOR ACCESS</span>
            </div>
            <div class="terminal-body">
                <div class="terminal-title">
                    <i class="fas fa-shield-alt"></i> RESTRICTED AREA <i class="fas fa-shield-alt"></i>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert-terminal">
                        <i class="fas fa-exclamation-triangle"></i> ERROR: <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!$showLoginForm): ?>
                    <!-- Access Code Form -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label><span class="prompt">$</span> ENTER ACCESS CODE:</label>
                            <input type="password" class="form-control" name="access_code" 
                                   placeholder="ACCESS_CODE_REQUIRED" required autofocus>
                        </div>
                        
                        <button type="submit" class="btn btn-terminal">
                            <i class="fas fa-unlock"></i> VERIFY ACCESS
                        </button>
                        
                        <div class="warning-text">
                            ⚠ Unauthorized access attempts are logged and monitored ⚠
                        </div>
                    </form>
                <?php else: ?>
                    <!-- NT Admin Login Form -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label><span class="prompt">$</span> USERNAME:</label>
                            <input type="text" class="form-control" name="username" 
                                   placeholder="NT_ADMIN_USERNAME" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label><span class="prompt">$</span> PASSWORD:</label>
                            <input type="password" class="form-control" name="password" 
                                   placeholder="NT_ADMIN_PASSWORD" required>
                        </div>
                        
                        <button type="submit" class="btn btn-terminal">
                            <i class="fas fa-sign-in-alt"></i> AUTHENTICATE
                        </button>
                    </form>
                <?php endif; ?>
                
                <div class="back-link">
                    <a href="login.php"><i class="fas fa-arrow-left"></i> RETURN TO STANDARD LOGIN</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
