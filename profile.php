<?php
session_start();
$conn = new mysqli("localhost", "root", "password", "bloodbank", 3306);

if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Link Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Arial
        }

        body {
            display: flex;
            background: #d64e3c
        }

        .sidebar {
            width: 260px;
            background: #2e4c8d;
            color: #fff;
            min-height: 100vh;
            padding: 22px
        }

        .btn {
             width: 210px;
            background: #2e4c8d;
            color: #fff;
            min-height: 20px;
            padding: 20px;
            outline: none;
            border: none;
            border-radius: 8px;
        }

        .profileBox {
            text-align: center;
            margin-bottom: 25px
        }

        .profileBox img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #ef4444;
            margin-bottom: 10px
        }

        .profileBox h3 {
            font-weight: 500
        }

        .menu {
            list-style: none;
            margin-top: 15px
        }

        .menu li {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer
        }

        .menu li:hover {
            background: #1f2937
        }

        .main {
            flex: 1;
            padding: 25px
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px
        }

        .date {
            color: #6b7280
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            margin-bottom: 18px
        }

        .userInfo p {
            margin: 6px 0;
            color: #374151
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 18px
        }

        .stat {
            background: #fff;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08)
        }

        .stat h4 {
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 6px
        }

        .stat h2 {
            color: #ef4444
        }

        .btn:hover {
            background: #1f1111
        }

        /* ensure anchor inside button appears white */
        .btn a {
            color: white;
            text-decoration: none;
        }

        .card.find-bank {
            margin-top: 28px;
        }

        .toggle {
            display: flex;
            gap: 20px;
            margin-top: 15px
        }

        .switch {
            background: #e5e7eb;
            border-radius: 30px;
            width: 90px;
            height: 34px;
            position: relative;
            cursor: pointer;
            transition: background 0.18s ease;
            outline: none;
        }

        .switch::after {
            content: "";
            width: 30px;
            height: 30px;
            background: #fff;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .3);
            transition: left 0.18s ease;
        }

        .switch:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25);
        }

        .switch.on {
            background: #ef4444;
        }

        .switch.on::after {
            left: 38px;
        }

        .notice {
            background: #fef3c7;
            border-radius: 12px;
            padding: 18px;
            margin-top: 18px;
            color: #92400e;
        }

        .darkMode {
            background-color: black;
            color: white;
        }

        body {
            transition: 0.3s;
        }

        .dark-mode {
            background-color: #121212;
            color: white;
        }

        .dark-mode .card {
            background-color: #1e1e1e;
            color: white;
        }

        .dark-mode button {
            background-color: crimson;
            color: white;
        }

        .dark-mode .switch {
            background: #4b5563;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="profileBox">

        </div>
        <ul class="menu">
            <button class="btn"><a href="index.php">Go To Home</a></button>
            <li>Edit Your Profile</li>
            <button onclick="toggleTheme()">🌙 Dark Mode</button>
            <li class="toggle">
                <span>Available To Donate</span>
                <div class="switch" role="switch" aria-checked="false" tabindex="0" data-key="available-to-donate">
                </div>
            </li>
            <li class="toggle">
                <span>Emergency Donor</span>
                <div class="switch" role="switch" aria-checked="false" tabindex="0" data-key="emergency-donor"></div>
            </li>
            <select onchange="changeLanguage(this.value)">
                <option value="en">English</option>
                <option value="hi">Hindi</option>
                <option value="od">Odia</option>
            </select>

            <li>Log Out</li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <h2>Dashboard</h2>
        </div>

        <div class="card">
            <img src="https://via.placeholder.com/90" alt="User Photo" align="right">
            <h3>Hello <?php echo $user['name']; ?></h3>

            <ul>
                <li><b>Address:</b> <?php echo $user['address']; ?></li>
                <li><b>Gmail:</b> <?php echo $user['email']; ?></li>
                <li><b>Mobile number:</b> <?php echo $user['mobile']; ?></li>
                <li><b>Pin Code:</b> <?php echo $user['pin']; ?></li>
            </ul>
        </div>
        <p>
        <h3>Overview</h3>
        </p>
        <div class="stats">
            <div class="stat">
                <h4>Donation</h4>
                <h2>0</h2>
            </div>
            <div class="stat">
                <h4>Blood Receive</h4>
                <h2>0</h2>
            </div>
            <div class="stat">
                <h4>Blood Group</h4> <?php echo $user['blood']; ?>
                <h2></h2>
            </div>
        </div>

        <div class="card find-bank">
            <h3>Find Near Blood Bank</h3>
        </div>

        <div class="notice">
            Every time you donate, your pulse, blood pressure, body temperature, and hemoglobin levels are checked,
            providing an informal snapshot of your health.
        </div>
    </div>

</body>

</html>
<script>
    // Change theme function
    function changeTheme() {
        document.body.classList.toggle("darkMode");
    }

    //Language change function
    function changeLanguage(lang) {

        if (lang === "hi") {
            document.querySelector("h2").innerText = "डैशबोर्ड";
        }

        if (lang === "od") {
            document.querySelector("h2").innerText = "ଡ୍ୟାସବୋର୍ଡ";
        }

        if (lang === "en") {
            document.querySelector("h2").innerText = "Dashboard";
        }

        localStorage.setItem("language", lang);
    }

    // Toggle Theme
    function toggleTheme() {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    }
</script>