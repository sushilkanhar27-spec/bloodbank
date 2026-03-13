<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blood Donor Registration</title>
    <link rel="stylesheet" href="regis.css">
</head>

<body>

    <!-- Top Navbar (copied style) -->
    <div class="navbar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="findblood.html">Find Donors</a></li>
            <li><a href="donate.html">Donate</a></li>
            <li class="right"><a href="loginpage.php">Login</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Blood Donor Registration</h2>

        <div class="section-header">
            <span>Donor Details</span>
            <p>Please fill details correctly</p>
        </div>

        <form class="form-grid" method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Blood Group</label>
                <select name="blood" required>
                    <option value="">Select Blood Group</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>
                </select>
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" id="dob" onchange="calculateAge()" required>
            </div>

            <div class="form-group">
                <label>Age</label>
                <input id="age" name="age" placeholder="Auto fill" readonly required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="mobile" placeholder="Enter phone number" maxlength="10">
            </div>

            <div class="form-group">
                <label>Email ID</label>
                <input type="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" placeholder="Enter hospital or area" required>
            </div>

            <div class="form-group">
                <label>Area Pincode</label>
                <input type="text" name="pin" placeholder="Enter area pincode" required>
            </div>

            <div class="form-group">
                <label>Last Donation Date</label>
                <input type="date" name="lastdonat">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <button type="submit" name="register" class="primary-btn">Register as Donor</button>
            </div>

        </form>
        <?php
        $con = mysqli_connect("localhost", "root", "password", "bloodbank", 3306);

        if (isset($_POST['register'])) {

            $name = $_POST['name'];
            $blood = $_POST['blood'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $pin = $_POST['pin'];
            $lastdonat = !empty($_POST['lastdonat']) ? $_POST['lastdonat'] : null;

            // ✅ Calculate Age
            $birthdate = new DateTime($dob);
            $today = new DateTime();
            $age = $today->diff($birthdate)->y;

            // ✅ Age Validation
            if ($age < 18 || $age > 60) {
                echo "<script>alert('Invalid Age! Donor age must be between 18 and 60 years.'); window.history.back();</script>";
                exit();
            }

            // ✅ 3-Month Rule (Only if user entered last donation date)
            if ($lastdonat !== null) {

                $lastDonationDate = new DateTime($lastdonat);
                $daysDifference = $today->diff($lastDonationDate)->days;

                if ($daysDifference < 90) {
                    echo "<script>alert('You must wait at least 3 months after last donation.'); window.history.back();</script>";
                    exit();
                }
            }
            // ✅ Already Registered Check (Email OR Mobile)
            $checkQuery = "SELECT * FROM users WHERE email='$email' OR mobile='$mobile'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script>alert('You are already registered with this Email or Mobile number.'); window.history.back();</script>";
                exit();
            }

            // ✅ Insert Into Database
            $query = "INSERT INTO users 
            (name,blood,dob,age,gender,mobile,email,address,pin,lastdonat)
            VALUES 
            ('$name','$blood','$dob','$age','$gender','$mobile','$email','$address','$pin',"
                . ($lastdonat !== null ? "'$lastdonat'" : "NULL") .
                ")";

            $execute = mysqli_query($con, $query);
            if ($execute) {
                echo "<script>alert('Registration Successful'); window.location.href='registration.php';</script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
        ?>
    </div>
    <script>
        // Auto Calculate Age from DOB
        document.getElementById("dob").addEventListener("change", function() {
            let dob = new Date(this.value);
            let today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            let m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            document.getElementById("age").value = age;
        });
        // Additional Validation for Age on DOB Change
        function calculateAge() {
            let dob = document.getElementById("dob").value;
            let birthDate = new Date(dob);
            let today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            let m = today.getMonth() - birthDate.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18 || age > 60) {
                alert("Age must be between 18 and 60 years.");
                document.getElementById("dob").value = "";
            }
        }
    </script>
</body>

</html>