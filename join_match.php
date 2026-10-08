<?php
// join_match.php - shows a join form and saves to match_participants + match_requests
session_start();
include('includes/db.php');

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$user    = $_SESSION['user'];
$userId  = (int)$user['id'];
$matchId = (int)($_GET['id'] ?? $_POST['match_id'] ?? 0);

if (!$matchId) {
    header('Location: view_match.php');
    exit;
}

// Find the match
$stmt = mysqli_prepare($conn, "SELECT match_name, location, match_date, max_participants FROM matches WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $matchId);
mysqli_stmt_execute($stmt);
$match = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$state = 'form';   // form | success | error
$msg   = '';

if (!$match) {
    $state = 'error'; $msg = 'This match does not exist.';
} elseif (strtotime($match['match_date']) < time()) {
    $state = 'error'; $msg = 'This match is already over, so you cannot join it.';
} else {
    // Already joined?
    $stmt = mysqli_prepare($conn, "SELECT id FROM match_participants WHERE match_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $matchId, $userId);
    mysqli_stmt_execute($stmt);
    $already = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Full?
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS c FROM match_participants WHERE match_id = ? AND status <> 'rejected'");
    mysqli_stmt_bind_param($stmt, 'i', $matchId);
    mysqli_stmt_execute($stmt);
    $count = (int)mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['c'];

    if ($already) {
        $state = 'error'; $msg = 'You have already joined this match.';
    } elseif ($count >= (int)$match['max_participants']) {
        $state = 'error'; $msg = 'Sorry, all spots are filled.';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $phone   = trim($_POST['phone'] ?? '');
        $skill   = $_POST['skill_level'] ?? 'Beginner';
        $message = trim($_POST['message'] ?? '');

        if (!in_array($skill, ['Beginner', 'Intermediate', 'Pro'], true)) $skill = 'Beginner';

        if (!preg_match('/^[0-9+\-\s]{7,15}$/', $phone)) {
            $msg = 'Please enter a valid phone number.';
        } else {
            // Save to BOTH tables (all or nothing)
            mysqli_begin_transaction($conn);
            try {
                $stmt = mysqli_prepare($conn,
                    "INSERT INTO match_participants (match_id, user_id, status, phone, skill_level, message)
                     VALUES (?, ?, 'pending', ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'iisss', $matchId, $userId, $phone, $skill, $message);
                mysqli_stmt_execute($stmt);

                $stmt = mysqli_prepare($conn,
                    "INSERT INTO match_requests (user_id, match_id, status) VALUES (?, ?, 'pending')");
                mysqli_stmt_bind_param($stmt, 'ii', $userId, $matchId);
                mysqli_stmt_execute($stmt);

                mysqli_commit($conn);
                $state = 'success';
                $msg = 'You joined "' . htmlspecialchars($match['match_name']) . '". The organizer will review your request.';
            } catch (Throwable $e) {
                mysqli_rollback($conn);
                $state = 'error';
                $msg = 'Could not save your request: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Match - SportsMatch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .box { background: white; border-radius: 15px; padding: 40px; max-width: 500px; width: 100%; }
        .center { text-align: center; }
        .icon { font-size: 4rem; margin-bottom: 20px; color: #4cc9f0; }
        .icon.bad { color: #f72585; }
        h1 { margin-bottom: 8px; color: #1e1e2d; }
        .sub { color: #666; margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin: 14px 0 6px; color: #1e1e2d; }
        input, select, textarea { width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 1rem; }
        input[readonly] { background: #f3f4f6; color: #666; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #4361ee; }
        .err { background: #fde8ef; color: #f72585; padding: 10px 14px; border-radius: 8px; margin-bottom: 10px; }
        .btn { padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin: 10px 5px 0; background: #6c757d; color: white; cursor: pointer; font-size: 1rem; }
        .btn-join { background: linear-gradient(135deg, #4cc9f0, #3aa8d0); }
    </style>
</head>
<body>
<div class="box">
<?php if ($state === 'form'): ?>
    <h1>Join Match</h1>
    <p class="sub">
        <strong><?php echo htmlspecialchars($match['match_name']); ?></strong><br>
        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($match['location']); ?> &middot;
        <i class="fas fa-calendar"></i> <?php echo date('M j, Y g:i A', strtotime($match['match_date'])); ?>
    </p>
    <?php if ($msg): ?><div class="err"><?php echo $msg; ?></div><?php endif; ?>

    <form method="POST" action="join_match.php?id=<?php echo $matchId; ?>">
        <input type="hidden" name="match_id" value="<?php echo $matchId; ?>">

        <label>Name</label>
        <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>

        <label>Email</label>
        <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>

        <label for="phone">Phone number *</label>
        <input type="text" id="phone" name="phone" required placeholder="9876543210"
               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">

        <label for="skill_level">Skill level</label>
        <select id="skill_level" name="skill_level">
            <option>Beginner</option>
            <option>Intermediate</option>
            <option>Pro</option>
        </select>

        <label for="message">Message to organizer (optional)</label>
        <textarea id="message" name="message" rows="3" maxlength="255"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

        <div class="center">
            <button type="submit" class="btn btn-join"><i class="fas fa-user-plus"></i> Confirm Join</button>
            <a href="view_match.php?id=<?php echo $matchId; ?>" class="btn"><i class="fas fa-arrow-left"></i> Cancel</a>
        </div>
    </form>
<?php else: ?>
    <div class="center">
        <div class="icon <?php echo $state === 'success' ? '' : 'bad'; ?>">
            <i class="fas <?php echo $state === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        </div>
        <h1><?php echo $state === 'success' ? 'Request Submitted' : 'Cannot Join'; ?></h1>
        <p class="sub"><?php echo $msg; ?></p>
        <a href="view_match.php?id=<?php echo $matchId; ?>" class="btn"><i class="fas fa-arrow-left"></i> Back to Match</a>
        <a href="dashboard.php" class="btn"><i class="fas fa-home"></i> Dashboard</a>
    </div>
<?php endif; ?>
</div>
</body>
</html>