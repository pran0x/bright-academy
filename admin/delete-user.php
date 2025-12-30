<?php
/**
 * Delete User
 */
require_once 'auth.php';

// Check permission
if (!hasPermission('users', 'delete')) {
    showAlert('আপনার এই অ্যাকশন করার অনুমতি নেই', 'error');
    redirectTo('users.php');
}

if (isset($_GET['id'])) {
    $deleteUserId = (int)$_GET['id'];
    
    // Prevent deleting yourself
    if ($deleteUserId === $userId) {
        showAlert('আপনি নিজের অ্যাকাউন্ট মুছতে পারবেন না', 'error');
        redirectTo('users.php');
    }
    
    $conn = getDBConnection();
    
    // Check if user exists and can be modified
    $stmt = $conn->prepare("SELECT username, role, can_be_modified FROM users WHERE id = ?");
    $stmt->bind_param("i", $deleteUserId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        showAlert('ব্যবহারকারী পাওয়া যায়নি', 'error');
        redirectTo('users.php');
    }
    
    $user = $result->fetch_assoc();
    
    if (!$user['can_be_modified']) {
        showAlert('এই ব্যবহারকারীকে মুছে ফেলা যাবে না (Protected)', 'error');
        redirectTo('users.php');
    }
    
    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $deleteUserId);
    
    if ($stmt->execute()) {
        logActivity('delete_user', 'users', "Deleted user: {$user['username']} ({$user['role']})");
        showAlert('ব্যবহারকারী সফলভাবে মুছে ফেলা হয়েছে', 'success');
    } else {
        showAlert('ব্যবহারকারী মুছতে ব্যর্থ হয়েছে', 'error');
    }
    
    $stmt->close();
    $conn->close();
}

redirectTo('users.php');
?>
