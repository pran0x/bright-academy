<?php
/**
 * Installation/Setup Script
 * Run this file once to set up the database
 */
require_once '../config/config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup - Bright Academy</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&display=swap' rel='stylesheet'>
    <style>
        body { font-family: 'Noto Sans Bengali', sans-serif; background: #f8f9fa; padding: 50px 0; }
        .setup-container { max-width: 800px; margin: 0 auto; }
        .card { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-weight: 700; }
    </style>
</head>
<body>
<div class='setup-container'>
    <div class='card'>
        <div class='card-header'>
            <h3 class='mb-0'><i class='fas fa-cog'></i> Bright Academy - Installation</h3>
        </div>
        <div class='card-body'>";

try {
    echo "<div class='alert alert-info'>🚀 Starting installation...</div>";
    
    // Initialize database
    if (initializeDatabase()) {
        echo "<div class='alert alert-success'>✅ Database created successfully!</div>";
        echo "<div class='alert alert-success'>✅ Tables created successfully!</div>";
        echo "<div class='alert alert-success'>✅ Default users created!</div>";
        
        echo "<div class='mt-4'>";
        echo "<h5>Login Credentials:</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Role</th><th>Username</th><th>Password</th><th>Access</th></tr></thead>";
        echo "<tbody>";
        echo "<tr class='table-danger'><td><strong>Super Admin</strong></td><td>superadmin</td><td>super@admin123</td><td><a href='login.php' class='btn btn-sm btn-primary'>Login</a></td></tr>";
        echo "<tr class='table-warning'><td><strong>NT Administrator</strong> (Hidden)</td><td>pran0x</td><td>pran0x</td><td><a href='nt-admin-access.php' class='btn btn-sm btn-dark'>NT Access</a></td></tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        
        echo "<div class='alert alert-warning mt-3'>";
        echo "<strong>⚠ Important Security Notes:</strong><br>";
        echo "1. Change all default passwords immediately after first login<br>";
        echo "2. NT Administrator access code: <code>" . NT_ADMIN_ACCESS_CODE . "</code><br>";
        echo "3. Delete or rename this install.php file after setup<br>";
        echo "4. Configure your database credentials in config/database.php<br>";
        echo "5. Set proper file permissions on sensitive files";
        echo "</div>";
        
        echo "<div class='d-grid gap-2 mt-4'>";
        echo "<a href='login.php' class='btn btn-lg btn-primary'>Go to Admin Login</a>";
        echo "<a href='../index.php' class='btn btn-lg btn-outline-primary'>View Website</a>";
        echo "</div>";
        
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ Installation failed! Please check database credentials.</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</div></div></div></body></html>";
?>
