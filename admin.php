<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle match deletion
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // First delete participants (due to foreign key constraints)
    $delete_participants_sql = "DELETE FROM match_participants WHERE match_id = '$delete_id'";
    mysqli_query($conn, $delete_participants_sql);
    
    // Then delete the match
    $delete_sql = "DELETE FROM matches WHERE id = '$delete_id'";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['admin_message'] = "Match deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['admin_message'] = "Error deleting match: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }
    header("Location: admin_matches.php");
    exit();
}

// Handle match creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_match'])) {
    $match_name = mysqli_real_escape_string($conn, $_POST['match_name']);
    $sport_type = mysqli_real_escape_string($conn, $_POST['sport_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $match_date = mysqli_real_escape_string($conn, $_POST['match_date']);
    $needs = mysqli_real_escape_string($conn, $_POST['needs']);
    
    $insert_sql = "INSERT INTO matches (match_name, sport_type, location, match_date, needs, created_by) 
                   VALUES ('$match_name', '$sport_type', '$location', '$match_date', '$needs', '{$_SESSION['user']['id']}')";
    
    if (mysqli_query($conn, $insert_sql)) {
        $_SESSION['admin_message'] = "Match created successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['admin_message'] = "Error creating match: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }
    header("Location: admin_matches.php");
    exit();
}

// Fetch all matches
$matches_sql = "SELECT m.*, 
                (SELECT COUNT(*) FROM match_participants mp WHERE mp.match_id = m.id) as participant_count
                FROM matches m 
                ORDER BY m.match_date DESC";
$matches_result = mysqli_query($conn, $matches_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Matches</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 5px solid #ff3838;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        main {
            padding: 30px;
        }
        
        h2 {
            color: #ee5a24;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }
        
        .admin-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .create-match-btn {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3);
            transition: all 0.3s ease;
        }
        
        .create-match-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 184, 148, 0.4);
        }
        
        .back-btn {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(116, 185, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(116, 185, 255, 0.4);
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #000;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #74b9ff;
            outline: none;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 184, 148, 0.4);
        }
        
        .matches-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .matches-table th {
            background: linear-gradient(135deg, #ee5a24 0%, #ff6b6b 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .matches-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .matches-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .matches-table tr:last-child td {
            border-bottom: none;
        }
        
        .action-btns {
            display: flex;
            gap: 10px;
        }
        
        .delete-btn {
            background: linear-gradient(135deg, #ff7675 0%, #d63031 100%);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(214, 48, 49, 0.3);
        }
        
        .view-btn {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(116, 185, 255, 0.3);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .no-matches {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            font-size: 1.2rem;
            color: #666;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            color: #666;
            border-top: 1px solid #eee;
            background: #f9f9f9;
        }
        
        @media (max-width: 768px) {
            .admin-actions {
                flex-direction: column;
            }
            
            .matches-table {
                display: block;
                overflow-x: auto;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <p class="subtitle">Manage Sports Matches</p>
        </header>
        
        <main>
            <h2>Match Management</h2>
            
            <?php if (isset($_SESSION['admin_message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] === 'success' ? 'success' : 'error'; ?>">
                    <?= $_SESSION['admin_message']; ?>
                </div>
                <?php unset($_SESSION['admin_message'], $_SESSION['message_type']); ?>
            <?php endif; ?>
            
            <div class="admin-actions">
                <button class="create-match-btn" onclick="openModal()">Create New Match</button>
                <a href="view_matches.php" class="back-btn">View Public Matches</a>
            </div>
            
            <?php if (mysqli_num_rows($matches_result) > 0): ?>
                <table class="matches-table">
                    <thead>
                        <tr>
                            <th>Match Name</th>
                            <th>Sport Type</th>
                            <th>Location</th>
                            <th>Date & Time</th>
                            <th>Participants</th>
                            <th>Needs</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($match = mysqli_fetch_assoc($matches_result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($match['match_name']); ?></td>
                                <td><?= htmlspecialchars($match['sport_type']); ?></td>
                                <td><?= htmlspecialchars($match['location']); ?></td>
                                <td><?= date('M j, Y g:i A', strtotime($match['match_date'])); ?></td>
                                <td style="text-align: center;"><?= $match['participant_count']; ?></td>
                                <td><?= htmlspecialchars($match['needs']); ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="view_matches.php" class="view-btn">View</a>
                                        <button class="delete-btn" onclick="confirmDelete(<?= $match['id']; ?>)">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-matches">
                    No matches found. Create your first match!
                </div>
            <?php endif; ?>
        </main>
        
        <footer>
            <p>&copy; <?= date('Y'); ?> Sports Match Finder. Admin Panel</p>
        </footer>
    </div>

    <!-- Create Match Modal -->
    <div id="createMatchModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="color: #ee5a24; margin-bottom: 20px;">Create New Match</h2>
            <form method="POST" action="admin_matches.php">
                <div class="form-group">
                    <label for="match_name">Match Name:</label>
                    <input type="text" id="match_name" name="match_name" required>
                </div>
                
                <div class="form-group">
                    <label for="sport_type">Sport Type:</label>
                    <select id="sport_type" name="sport_type" required>
                        <option value="">Select Sport</option>
                        <option value="Football">Football</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Baseball">Baseball</option>
                        <option value="Hockey">Hockey</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>
                </div>
                
                <div class="form-group">
                    <label for="match_date">Date & Time:</label>
                    <input type="datetime-local" id="match_date" name="match_date" required>
                </div>
                
                <div class="form-group">
                    <label for="needs">Additional Needs (optional):</label>
                    <textarea id="needs" name="needs" rows="3" placeholder="E.g., Bring your own equipment, specific skills required..."></textarea>
                </div>
                
                <button type="submit" name="create_match" class="submit-btn">Create Match</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('createMatchModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('createMatchModal').style.display = 'none';
        }
        
        function confirmDelete(matchId) {
            if (confirm('Are you sure you want to delete this match? This action cannot be undone and will remove all participants.')) {
                window.location.href = 'admin_matches.php?delete_id=' + matchId;
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('createMatchModal');
            if (event.target === modal) {
                closeModal();
            }
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>