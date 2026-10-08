<?php
session_start();
include('includes/db.php');
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if (isset($_GET['id'])) {
    $match_id = intval($_GET['id']);
    
    // First delete participants to maintain referential integrity
    mysqli_query($conn, "DELETE FROM match_participants WHERE match_id = $match_id");
    
    // Then delete the match
    $sql = "DELETE FROM matches WHERE id = $match_id";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Match deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting match: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No match ID provided']);
}
?>