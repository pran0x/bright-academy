<?php
/**
 * Delete Student
 */
require_once 'auth.php';

// Check permission
if (!hasPermission('students', 'delete')) {
    showAlert('আপনার এই অ্যাকশন করার অনুমতি নেই', 'error');
    redirectTo('students.php');
}

if (isset($_GET['id'])) {
    $deleteStudentId = (int)$_GET['id'];
    
    $conn = getDBConnection();
    
    // Get student info
    $stmt = $conn->prepare("SELECT student_id, student_name FROM students WHERE id = ?");
    $stmt->bind_param("i", $deleteStudentId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        showAlert('শিক্ষার্থী পাওয়া যায়নি', 'error');
        redirectTo('students.php');
    }
    
    $student = $result->fetch_assoc();
    
    // Delete student
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $deleteStudentId);
    
    if ($stmt->execute()) {
        logActivity('delete_student', 'students', "Deleted student: {$student['student_id']} - {$student['student_name']}");
        showAlert('শিক্ষার্থী সফলভাবে মুছে ফেলা হয়েছে', 'success');
    } else {
        showAlert('শিক্ষার্থী মুছতে ব্যর্থ হয়েছে', 'error');
    }
    
    $stmt->close();
    $conn->close();
}

redirectTo('students.php');
?>
