<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];
?>

<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="./css/dashboard.css?v=5">

<!-- Moving sports background -->
<div class="bg-slider" aria-hidden="true">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>

<main class="dashboard-content">
    <h2>Welcome, <?= htmlspecialchars($user['name']); ?>!</h2>
    <p>
        <a href="view_match.php">View Matches</a>
        <a href="view_match.php">Join Match</a>
        <a href="logout.php">Logout</a>
    </p>
</main>
<?php include('includes/footer.php'); ?>