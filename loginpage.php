<?php
session_start();
$conn = new mysqli("localhost", "root", "password", "bloodbank", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $sql = "SELECT * FROM users WHERE email='$email' AND mobile='$mobile'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        header("Location: profile.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Mobile Number');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Login Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('background.jpg') no-repeat center;
            background-size: cover;
            background-attachment: fixed;
            /* Keeps background fixed during scroll */
        }

        .container {
            position: relative;
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            /* Semi-transparent white background */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            /* Frosted glass effect */
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .container h2 {
            text-align: center;
            color: #200a0a;
            font-size: 2em;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            border-bottom: 2px solid rgb(43, 16, 16);
            color: #181313;
            font-size: 1em;
            padding: 5px 0;
            outline: none;
            transition: border-bottom-color 0.3s ease;
        }

        .form-group input:focus {
            border-bottom-color: #00bcd4;
            /* Highlight color on focus */
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: rgba(29, 12, 12, 0.7);
            font-size: 1em;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus~label,
        .form-group input:valid~label {
            /* :valid works for inputs with required attribute */
            top: -15px;
            font-size: 0.8em;
            color: #181313;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
            height: auto;
            accent-color: #00bcd4;
            /* Checkbox accent color */
        }

        .form-group input[type="checkbox"]~label {
            transform: none;
            /* Override default label positioning for checkbox */
            top: auto;
            left: auto;
            font-size: 0.9em;
            color: rgba(24, 17, 17, 0.8);
        }

        .login-btn {
            width: 100%;
            height: 50px;
            background: rgba(0, 188, 212, 0.7);
            /* Teal color with transparency */
            border: none;
            border-radius: 25px;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
        }

        .login-btn:hover {
            background: rgba(0, 188, 212, 1);
            /* Solid teal on hover */
        }

        .options {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .options a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .options a:hover {
            color: #00bcd4;
        }

        .options p {
            color: rgba(255, 255, 255, 0.8);
        }

        .options p a {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="form-group">
                <input type="tel" name="mobile" id="mobile" maxlength="10" required>
                <label for="mobile">Mobile Number</label>
                <i class="fas fa-phone"></i>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="login-btn" name="login" id="login-btn">Login</button>
        </form>
        <div class="options">
            <a href="#">Forgot account?</a>
            <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
        </div>

    </div>

    <script src="script.js">
        // Example: Adding a class to the button on click for a visual effect
        const loginBtn = document.getElementById('login-btn');
        loginBtn.addEventListener('click', () => {
            loginBtn.classList.add('clicked');
            setTimeout(() => {
                loginBtn.classList.remove('clicked');
            }, 300); // Remove class after 300ms
        });
    </script>
</body>

</html>