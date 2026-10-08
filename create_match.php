<?php
// create_match.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportsbuddy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get POST data
$match_name = $_POST['match_name'] ?? '';
$sport_type = $_POST['sport_type'] ?? '';
$location = $_POST['location'] ?? '';
$match_date = $_POST['match_date'] ?? '';
$max_participants = $_POST['max_participants'] ?? '';
$needs = $_POST['needs'] ?? '';

// Validate required fields
if (empty($match_name) || empty($sport_type) || empty($location) || empty($match_date) || empty($max_participants)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Insert into database
$sql = "INSERT INTO create_matches (match_name, sport_type, location, match_date, max_participants, needs, created_at, status) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), 'upcoming')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssis", $match_name, $sport_type, $location, $match_date, $max_participants, $needs);

if ($stmt->execute()) {
    $match_id = $stmt->insert_id;
    echo json_encode([
        'success' => true, 
        'message' => 'Match created successfully',
        'match_id' => $match_id
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating match: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>