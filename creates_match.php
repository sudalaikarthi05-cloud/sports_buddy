<?php
session_start();
include('includes/db.php');

// Check if user is admin (you should implement proper admin authentication)
if (!isset($_SESSION['user']) /* || $_SESSION['user']['role'] != 'admin' */) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $match_name = mysqli_real_escape_string($conn, $_POST['match_name']);
    $sport_type = mysqli_real_escape_string($conn, $_POST['sport_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $match_date = mysqli_real_escape_string($conn, $_POST['match_date']);
    $max_participants = intval($_POST['max_participants']);
    $needs = mysqli_real_escape_string($conn, $_POST['needs']);
    
    // Insert match into database
    $sql = "INSERT INTO cretes_matches (match_name, sport_type, location, match_date, max_participants, needs, created_at) 
            VALUES ('$match_name', '$sport_type', '$location', '$match_date', $max_participants, '$needs', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Match created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>