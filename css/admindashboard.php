<?php
session_start();
include 'includes/db.php'; // your DB connection file

// Only admin can open
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all registered users
$users = mysqli_query($conn, "SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");

// Create match
if (isset($_POST['create_match'])) {
    $match_name = $_POST['match_name'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    mysqli_query($conn, "INSERT INTO matches (match_name, location, match_date) VALUES ('$match_name', '$location', '$date')");
    $success = "Match created successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {font-family:Arial; background:#f4f4f4; padding:20px;}
        h1 {color:#333;}
        table {width:100%; border-collapse:collapse; margin-bottom:20px;}
        table, th, td {border:1px solid #ccc;}
        th, td {padding:10px; text-align:left;}
        th {background:#eee;}
        form {background:white; padding:20px; border-radius:10px;}
        input, button {padding:10px; margin:5px 0; width:100%; border:1px solid #ccc; border-radius:5px;}
        button {background:#007bff; color:white; border:none;}
        button:hover {background:#0056b3;}
        .success {color:green;}
    </style>
</head>
<body>

<h1>Welcome Admin</h1>
<a href="logout.php" style="background:red;color:white;padding:10px;text-decoration:none;border-radius:5px;">Logout</a>

<h2>Registered Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Registered Date</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($users)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Create Match</h2>
<?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
<form method="POST">
    <input type="text" name="match_name" placeholder="Match Name" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="date" name="date" required>
    <button type="submit" name="create_match">Create Match</button>
</form>

</body>
</html>
