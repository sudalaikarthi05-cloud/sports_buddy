<?php
session_start();
include('includes/db.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($email) && !empty($pass)) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Please enter both email and password.');</script>";
    }
}
?>

<?php include('includes/header.php'); ?>

<style>
    .login-container {
        max-width: 420px;
        margin: 60px auto;
        padding: 40px 35px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        backdrop-filter: blur(5px);
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .login-header h2 {
        font-size: 32px;
        margin-bottom: 8px;
        font-weight: 700;
        background: linear-gradient(135deg, #3498db, #8e44ad);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .login-header p {
        color: #7f8c8d;
        font-size: 16px;
        margin-top: 0;
    }
    
    .form-group {
        margin-bottom: 22px;
        position: relative;
    }
    
    .input-icon {
        position: relative;
    }
    
    .input-icon i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
        font-size: 18px;
    }
    
    .input-icon input {
        width: 100%;
        padding: 15px 15px 15px 50px;
        border: 2px solid #e1e8ed;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
        box-sizing: border-box;
        background-color: #f8f9fa;
    }
    
    .input-icon input:focus {
        outline: none;
        border-color: #3498db;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
    }
    
    .input-icon input::placeholder {
        color: #aab7c2;
    }
    
    button {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }
    
    button:hover {
        background: linear-gradient(135deg, #2980b9, #3498db);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    }
    
    button:active {
        transform: translateY(0);
    }
    
    .register-link {
        text-align: center;
        margin-top: 25px;
        color: #7f8c8d;
        font-size: 15px;
    }
    
    .register-link a {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    
    .register-link a:hover {
        color: #2980b9;
        text-decoration: underline;
    }
    
    .divider {
        display: flex;
        align-items: center;
        margin: 25px 0;
    }
    
    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #e1e8ed;
    }
    
    .divider span {
        padding: 0 15px;
        color: #95a5a6;
        font-size: 14px;
    }
    
    .forgot-password {
        text-align: center;
        margin-top: 15px;
    }
    
    .forgot-password a {
        color: #7f8c8d;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s;
    }
    
    .forgot-password a:hover {
        color: #3498db;
    }
    
    @media (max-width: 480px) {
        .login-container {
            margin: 30px 20px;
            padding: 30px 25px;
        }
    }
</style>

<div class="login-container">
    <div class="login-header">
        <h2>Welcome Back</h2>
        <p>Sign in to your account to continue</p>
    </div>
    
    <form method="POST">
        <div class="form-group">
            <div class="input-icon">
                <i>✉️</i>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i>🔒</i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <button name="login">Sign In</button>
        
        <div class="forgot-password">
            <a href="#">Forgot your password?</a>
        </div>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Create one here</a>
        </div>
    </form>
</div>

<?php include('includes/footer.php'); ?>