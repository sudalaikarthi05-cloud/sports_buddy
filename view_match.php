<?php
// view_match.php - reads matches from the database (original design kept)
session_start();
include('includes/db.php');

$matchId = (int)($_GET['id'] ?? 0);
$userId  = isset($_SESSION['user']) ? (int)$_SESSION['user']['id'] : 0;

// All matches + real participant count
$sql = "SELECT m.*,
        (SELECT COUNT(*) FROM match_participants p
         WHERE p.match_id = m.id AND p.status <> 'rejected') AS participants
        FROM matches m
        ORDER BY m.match_date ASC";
$result = mysqli_query($conn, $sql);
$matches = [];
while ($row = mysqli_fetch_assoc($result)) {
    $matches[] = $row;
}

// Find selected match
$selected_match = null;
foreach ($matches as $match) {
    if ((int)$match['id'] === $matchId) {
        $selected_match = $match;
        break;
    }
}

// Has the logged-in user already joined this match?
$alreadyJoined = false;
if ($selected_match && $userId) {
    $stmt = mysqli_prepare($conn, "SELECT id FROM match_participants WHERE match_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $matchId, $userId);
    mysqli_stmt_execute($stmt);
    $alreadyJoined = (bool)mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// Status helper: returns [label, css class]
function match_status($date) {
    $diff = strtotime($date) - time();
    if ($diff < 0) {
        return ['Completed', 'status-completed'];
    } elseif ($diff < 24 * 60 * 60) {
        return ['Active', 'status-active'];
    }
    return ['Upcoming', 'status-upcoming'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $selected_match ? htmlspecialchars($selected_match['match_name']) : 'All Matches'; ?> - SportsMatch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --dark: #1e1e2d;
            --light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            50% { background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); }
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .match-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            overflow: hidden;
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .matches-sidebar {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            padding: 25px;
            max-height: 85vh;
            overflow-y: auto;
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--light);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px;
            margin: -25px -25px 25px -25px;
            border-radius: 20px 20px 0 0;
        }

        .sidebar-header h2 {
            font-size: 1.6rem;
            margin-bottom: 8px;
        }

        .match-count {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        .match-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .match-item {
            background: var(--light);
            padding: 18px;
            border-radius: 15px;
            border-left: 5px solid var(--primary);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .match-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s;
        }

        .match-item:hover::before {
            left: 100%;
        }

        .match-item:hover {
            transform: translateX(8px) scale(1.02);
            background: linear-gradient(135deg, var(--light), #e9ecef);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.2);
        }

        .match-item.active {
            border-left-color: var(--success);
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1), rgba(67, 97, 238, 0.05));
            transform: translateX(5px);
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(76, 201, 240, 0.3); }
            50% { box-shadow: 0 0 30px rgba(76, 201, 240, 0.6); }
        }

        .match-item h4 {
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .match-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
        }

        .sport-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .match-details-small {
            display: flex;
            gap: 15px;
            margin-top: 8px;
            font-size: 0.8rem;
            color: #666;
        }

        .match-details-small span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .match-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .match-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .match-header h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .sport-type {
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 25px;
            display: inline-block;
            font-size: 1rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            position: relative;
        }

        .match-details {
            padding: 40px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateX(10px);
            border-bottom-color: var(--primary);
        }

        .detail-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
            transition: all 0.3s ease;
        }

        .detail-item:hover .detail-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .detail-content h3 {
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 1.2rem;
        }

        .detail-content p {
            color: #666;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .match-actions {
            padding: 30px;
            background: linear-gradient(135deg, var(--light), #f0f2f5);
            display: flex;
            gap: 20px;
            justify-content: space-between;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(108, 117, 125, 0.4);
        }

        .btn-join {
            background: linear-gradient(135deg, var(--success), #3aa8d0);
            color: white;
            box-shadow: 0 8px 25px rgba(76, 201, 240, 0.3);
        }

        .btn-join:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(76, 201, 240, 0.4);
        }

        .btn-disabled {
            background: linear-gradient(135deg, #adb5bd, #868e96);
            color: white;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .status-upcoming {
            background: linear-gradient(135deg, var(--warning), #f9ac4d);
            color: white;
        }

        .status-active {
            background: linear-gradient(135deg, var(--success), #3aa8d0);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, var(--danger), #f8458d);
            color: white;
        }

        .no-match-selected {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 40px;
            text-align: center;
            animation: bounceIn 1s ease-out;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .no-match-icon {
            font-size: 5rem;
            color: var(--primary);
            margin-bottom: 25px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .no-match-selected h2 {
            color: var(--dark);
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .no-match-selected p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        /* Custom scrollbar */
        .matches-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .matches-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .matches-sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
        }

        .matches-sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main Match Details -->
        <div class="match-container">
            <?php if ($selected_match):
                [$status_label, $status_class] = match_status($selected_match['match_date']);
                $isCompleted = ($status_label === 'Completed');
                $isFull = ((int)$selected_match['participants'] >= (int)$selected_match['max_participants']);
            ?>
                <div class="match-header">
                    <h1><?php echo htmlspecialchars($selected_match['match_name']); ?></h1>
                    <div class="sport-type"><?php echo htmlspecialchars($selected_match['sport_type']); ?></div>
                </div>

                <div class="match-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Location</h3>
                            <p><?php echo htmlspecialchars($selected_match['location']); ?></p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Date &amp; Time</h3>
                            <p><?php echo date('F j, Y g:i A', strtotime($selected_match['match_date'])); ?></p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Participants</h3>
                            <p><?php echo (int)$selected_match['participants']; ?> / <?php echo (int)$selected_match['max_participants']; ?> spots filled</p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Status</h3>
                            <p>
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_label; ?></span>
                            </p>
                        </div>
                    </div>

                    <?php if (!empty($selected_match['needs'])): ?>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Additional Needs</h3>
                            <p><?php echo htmlspecialchars($selected_match['needs']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="match-actions">
                    <a href="dashboard.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <?php if ($alreadyJoined): ?>
                        <span class="btn btn-disabled">
                            <i class="fas fa-check"></i> Already Joined
                        </span>
                    <?php elseif ($isCompleted): ?>
                        <span class="btn btn-disabled">
                            <i class="fas fa-ban"></i> Match Completed
                        </span>
                    <?php elseif ($isFull): ?>
                        <span class="btn btn-disabled">
                            <i class="fas fa-ban"></i> Match Full
                        </span>
                    <?php else: ?>
                        <a href="join_match.php?id=<?php echo (int)$selected_match['id']; ?>" class="btn btn-join">
                            <i class="fas fa-user-plus"></i> Join Match
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="no-match-selected">
                    <div class="no-match-icon">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <h2>Select a Match</h2>
                    <p>Choose a match from the sidebar to view details and join</p>
                    <a href="dashboard.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Matches Sidebar -->
        <div class="matches-sidebar">
            <div class="sidebar-header">
                <h2>Available Matches</h2>
                <div class="match-count"><?php echo count($matches); ?> matches</div>
            </div>

            <div class="match-list">
                <?php if (!$matches): ?>
                    <p style="text-align:center; color:#666;">No matches yet.</p>
                <?php endif; ?>

                <?php foreach ($matches as $sidebar_match):
                    [$sidebar_status, $sidebar_status_class] = match_status($sidebar_match['match_date']);
                ?>
                    <div class="match-item <?php echo ($matchId === (int)$sidebar_match['id']) ? 'active' : ''; ?>"
                         onclick="window.location.href='view_match.php?id=<?php echo (int)$sidebar_match['id']; ?>'">
                        <h4><?php echo htmlspecialchars($sidebar_match['match_name']); ?></h4>
                        <div class="match-meta">
                            <span class="sport-badge"><?php echo htmlspecialchars($sidebar_match['sport_type']); ?></span>
                            <span class="status-badge <?php echo $sidebar_status_class; ?>"><?php echo $sidebar_status; ?></span>
                        </div>
                        <div class="match-details-small">
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($sidebar_match['location']); ?></span>
                            <span><i class="fas fa-calendar"></i> <?php echo date('M j, g:i A', strtotime($sidebar_match['match_date'])); ?></span>
                            <span><i class="fas fa-users"></i> <?php echo (int)$sidebar_match['participants']; ?>/<?php echo (int)$sidebar_match['max_participants']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to active match in sidebar with smooth animation
        document.addEventListener('DOMContentLoaded', function() {
            const activeMatch = document.querySelector('.match-item.active');
            if (activeMatch) {
                setTimeout(() => {
                    activeMatch.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                }, 500);
            }

            // Add hover effects to all match items
            const matchItems = document.querySelectorAll('.match-item');
            matchItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(8px) scale(1.02)';
                });
                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(0) scale(1)';
                    }
                });
            });
        });
    </script>
</body>
</html>