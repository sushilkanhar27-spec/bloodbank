<?php
$conn = new mysqli("localhost", "root", "password", "bloodbank", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* 🔎 SEARCH DONOR */
if (isset($_POST['search'])) {

    $blood = $_POST['blood_group'];
    $pin = intval($_POST['pincode']);
    $ignorePin = $_POST['ignore_pin'] === 'true' || $_POST['ignore_pin'] === '1';

    if ($ignorePin) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE blood=?");
        $stmt->bind_param("s", $blood);
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE blood=? AND pin=?");
        $stmt->bind_param("si", $blood, $pin);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mobile = htmlspecialchars($row['mobile'], ENT_QUOTES, 'UTF-8');
            echo "
            <div class='donor-card'>
                <h3>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</h3>
                <p><b>Blood Group:</b> " . htmlspecialchars($row['blood'], ENT_QUOTES, 'UTF-8') . "</p>
                <p><b>Mobile:</b> $mobile</p>
                <p><b>Address:</b> " . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . "</p>
                <p><b>Pincode:</b> " . htmlspecialchars($row['pin'], ENT_QUOTES, 'UTF-8') . "</p>
                <button class='donor-btn' data-mobile='$mobile'>Send Request</button>
            </div>
            ";
        }
    } else {
        echo "<h3>No Donor Found</h3>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Blood Request</title>
    <link rel="stylesheet" href="find.css">
</head>

<body>

    <div class="container">
        <h1>🩸 Blood Request Form</h1>
        <form class="request-form" id="requestForm">

            <div class="toggle">
                <span>Blood Needed - All Areas</span>
                <div class="switch" role="switch" aria-checked="false" tabindex="0"></div>
                <input type="checkbox" id="ignorePin" style="display:none" aria-hidden="true">
            </div>
            <label>Patient Name</label>
            <input type="text" placeholder="Enter patient name" name="patient_Name" required>

            <label>Required Blood Group</label>
            <select name="blood_group" required>
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

            <label>Location / Area</label>
            <input type="text" name="address" placeholder="Enter hospital or area" required>

            <label>Pincode</label>
            <input type="tel" name="pincode" placeholder="Enter pincode" required>

            <label>Contact Number</label>
            <input type="tel" name="mobile" placeholder="Enter mobile number" maxlength="10" required>

            <label>Urgent Message</label>
            <textarea name="massage" placeholder="Any additional information..." rows="4"></textarea>

            <button type="submit">Request Blood</button>
        </form>
        <div id="result" style="margin-top:20px;"></div>
    </div>
    <script>
        // Toggle Switch Logic
        document.addEventListener('DOMContentLoaded', function() {
            const switchDiv = document.querySelector('.switch');
            const checkbox = document.getElementById('ignorePin');

            function toggleSwitch() {
                checkbox.checked = !checkbox.checked;
                // visual state uses "on" class to match CSS
                switchDiv.classList.toggle('on');
                switchDiv.setAttribute('aria-checked', checkbox.checked);
            }

            switchDiv.addEventListener('click', toggleSwitch);

            // Allow toggle with keyboard (Space or Enter)
            switchDiv.addEventListener('keydown', function(event) {
                if (event.key === ' ' || event.key === 'Enter') {
                    event.preventDefault();
                    toggleSwitch();
                }
            });
        });
        document.getElementById("requestForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append("search", true);
            formData.append("ignore_pin", document.getElementById("ignorePin").checked);

            fetch("findblood.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    document.getElementById("result").innerHTML = data;
                });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('donor-btn')) {
                const mobile = e.target.dataset.mobile;
                alert("Request sent to donor: " + mobile);
            }
        });
    </script>

</body>

</html>