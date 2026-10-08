<?php
session_start();
include('includes/db.php');

// Check if user is admin
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['request_id']) && isset($_GET['status'])) {
    $request_id = intval($_GET['request_id']);
    $status = $_GET['status'] === 'accepted' ? 'accepted' : 'rejected';
    
    // Update request status
    $sql = "UPDATE match_requests SET status = '$status' WHERE id = $request_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: join_match.php?success=Request " . $status);
    } else {
        header("Location: join_match.php?error=Update failed");
    }
} else {
    header("Location: join_match.php");
}
exit();