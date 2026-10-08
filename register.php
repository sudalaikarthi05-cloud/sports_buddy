<?php
include('includes/db.php');

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $skill = $_POST['skill'];
    $pass = $_POST['password'];

    $sql = "INSERT INTO users(name, email, password) VALUES('$name', '$email', '$pass')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Registered successfully');
        window.location.href='index.php';
        </script>";
    } else {
        echo "<script>alert('Registration Failed.');
        window.location.href='register.php';
        </script>";
    }
}
?>

<?php include('includes/header.php'); ?>

<style>
    .register-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
    }
    
    .register-header h2 {
        font-size: 28px;
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .register-header p {
        color: #7f8c8d;
        font-size: 16px;
    }
    
    .form-group {
        margin-bottom: 20px;
        position: relative;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #2c3e50;
        font-size: 14px;
    }
    
    input, select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e8ed;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
        box-sizing: border-box;
    }
    
    input:focus, select:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }
    
    .error {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }
    
    .valid {
        border-color: #2ecc71;
    }
    
    .invalid {
        border-color: #e74c3c;
    }
    
    .password-strength {
        height: 4px;
        margin-top: 8px;
        border-radius: 2px;
        background-color: #ecf0f1;
        overflow: hidden;
    }
    
    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s;
    }
    
    .password-strength-weak {
        background-color: #e74c3c;
        width: 30%;
    }
    
    .password-strength-medium {
        background-color: #f39c12;
        width: 60%;
    }
    
    .password-strength-strong {
        background-color: #2ecc71;
        width: 100%;
    }
    
    button {
        width: 100%;
        padding: 14px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    
    button:hover {
        background-color: #2980b9;
    }
    
    .login-link {
        text-align: center;
        margin-top: 20px;
        color: #7f8c8d;
        font-size: 15px;
    }
    
    .login-link a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
    }
    
    .login-link a:hover {
        text-decoration: underline;
    }
    
    .input-icon {
        position: relative;
    }
    
    .input-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
    }
    
    .input-icon input {
        padding-left: 45px;
    }
    
    .skill-icon {
        display: inline-block;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        vertical-align: middle;
        background-size: contain;
        background-repeat: no-repeat;
    }
</style>

<div class="register-container">
    <div class="register-header">
        <h2>Create Your Account</h2>
        <p>Join our community and showcase your skills</p>
    </div>
    
    <form method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-icon">
                <i>👤</i>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <span class="error" id="nameError">Name should contain only letters and spaces.</span>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-icon">
                <i>✉️</i>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <span class="error" id="emailError">Enter a valid email address.</span>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <div class="input-icon">
                <i>🏠</i>
                <input type="text" id="address" name="Address" placeholder="Enter your address" required>
            </div>
            <span class="error" id="addressError">Address must be at least 5 characters long.</span>
        </div>

        <div class="form-group">
            <label for="skill">Primary Skill</label>
            <select id="skill" name="skill" required>
                <option value="">Select your skill</option>
                <option value="Cricket">🏏 Cricket</option>
                <option value="Football">⚽ Football</option>
                <option value="Volleyball">🏐 Volleyball</option>
                <option value="Basketball">🏀 Basketball</option>
                <option value="Chess">♟️ Chess</option>
            </select>
            <span class="error" id="skillError">Please select your skill.</span>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-icon">
                <i>🔒</i>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="password-strength">
                <div class="password-strength-bar" id="passwordStrength"></div>
            </div>
            <span class="error" id="passwordError">Password must be at least 6 chars, include 1 number & 1 special character.</span>
        </div>

        <button name="register">Create Account</button>
        
        <div class="login-link">
            Already have an account? <a href="index.php">Sign In</a>
        </div>
    </form>
</div>

<script>
function showError(element, errorId, isValid) {
    let errorElement = document.getElementById(errorId);
    if (isValid) {
        element.classList.add("valid");
        element.classList.remove("invalid");
        errorElement.style.display = "none";
    } else {
        element.classList.add("invalid");
        element.classList.remove("valid");
        errorElement.style.display = "block";
    }
}

function validateName() {
    let name = document.getElementById("name");
    let regex = /^[A-Za-z\s]+$/;
    showError(name, "nameError", regex.test(name.value.trim()));
}

function validateEmail() {
    let email = document.getElementById("email");
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    showError(email, "emailError", regex.test(email.value.trim()));
}

function validateAddress() {
    let address = document.getElementById("address");
    showError(address, "addressError", address.value.trim().length >= 5);
}

function validateSkill() {
    let skill = document.getElementById("skill");
    showError(skill, "skillError", skill.value !== "");
}

function validatePassword() {
    let password = document.getElementById("password");
    let regex = /^(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/;
    showError(password, "passwordError", regex.test(password.value));
    
    // Update password strength indicator
    let strengthBar = document.getElementById("passwordStrength");
    if (password.value.length === 0) {
        strengthBar.className = "password-strength-bar";
        strengthBar.style.width = "0%";
    } else if (password.value.length < 6) {
        strengthBar.className = "password-strength-bar password-strength-weak";
    } else if (!regex.test(password.value)) {
        strengthBar.className = "password-strength-bar password-strength-medium";
    } else {
        strengthBar.className = "password-strength-bar password-strength-strong";
    }
}

function validateForm() {
    validateName();
    validateEmail();
    validateAddress();
    validateSkill();
    validatePassword();
    return document.querySelectorAll(".invalid").length === 0;
}

// Real-time validation events
document.getElementById("name").addEventListener("input", validateName);
document.getElementById("email").addEventListener("input", validateEmail);
document.getElementById("address").addEventListener("input", validateAddress);
document.getElementById("skill").addEventListener("change", validateSkill);
document.getElementById("password").addEventListener("input", validatePassword);
</script>

<?php include('includes/footer.php'); ?>