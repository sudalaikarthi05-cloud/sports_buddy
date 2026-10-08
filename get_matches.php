<?php
include('includes/db.php');
header('Content-Type: application/json');

$sql = "SELECT m.*, 
        (SELECT COUNT(*) FROM match_participants mp WHERE mp.match_id = m.id) as participant_count
        FROM matches m 
        ORDER BY m.match_date DESC";

$result = mysqli_query($conn, $sql);
$matches = [];

while ($row = mysqli_fetch_assoc($result)) {
    $matches[] = $row;
}

echo json_encode($matches);
?>