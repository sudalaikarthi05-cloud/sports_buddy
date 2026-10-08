<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Sports | Sports Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* Gradient background and smooth fade-in animation */
        body {
            background: linear-gradient(to right, #6dd5ed, #2193b0);
            animation: fadeIn 1s ease-in-out;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.15); /* semi-transparent white */
            backdrop-filter: blur(10px); /* glass effect */
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: transform 0.4s ease, box-shadow 0.3s ease, background-color 0.4s;
        }

        .card:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
            background: rgba(255, 255, 255, 0.25);
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 180px;
            object-fit: cover;
        }

        .btn-view {
            background-color: #ffffff;
            color: #007bff;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-view:hover {
            background-color: #007bff;
            color: white;
        }

        h2 {
            color: white;
            font-weight: bold;
            animation: slideDown 1s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">🏅 Available Sports</h2>

    <div class="row">
        <?php
        $sports = [
            ["name" => "Cricket", "image" => "css/images/cricketanimation2.jpg"],
            ["name" => "Football", "image" => "css/images/footballAnimate2.webp"],
            ["name" => "Badminton", "image" => "css/images/batmitton.jpg"],
            ["name" => "Tennis", "image" => "css/tennies_animate.jpeg"],
            ["name" => "Basketball", "image" => "css/images/basketball_animated.jpg"],
            ["name" => "Volleyball", "image" => "css/images/volleyballl_animate.webp"]
        ];

        foreach ($sports as $sport) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $sport['image']; ?>" class="card-img-top" alt="<?php echo $sport['name']; ?>">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $sport['name']; ?></h5>
                    <a href="view_matches.php?sport=<?php echo urlencode($sport['name']); ?>" class="btn btn-view">View Matches</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
