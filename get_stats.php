<?php
include('includes/db.php');
header('Content-Type: application/json');

// Total matches
$total_matches_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM matches");
$total_matches = mysqli_fetch_assoc($total_matches_result)['total'];

// Active participants (total participants across all matches)
$active_participants_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM match_participants");
$active_participants = mysqli_fetch_assoc($active_participants_result)['total'];

// Sports types (distinct count)
$sports_types_result = mysqli_query($conn, "SELECT COUNT(DISTINCT sport_type) as total FROM matches");
$sports_types = mysqli_fetch_assoc($sports_types_result)['total'];

// Locations (distinct count)
$locations_result = mysqli_query($conn, "SELECT COUNT(DISTINCT location) as total FROM matches");
$locations = mysqli_fetch_assoc($locations_result)['total'];

echo json_encode([
    'total_matches' => $total_matches,
    'active_participants' => $active_participants,
    'sports_types' => $sports_types,
    'locations' => $locations
]);
?>