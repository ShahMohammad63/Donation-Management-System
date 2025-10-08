<?php
// Connect to the database
include 'connect.php';

// Fetch the latest organization ID
$query = "SELECT MAX(Organization_ID) AS last_id FROM organization_profile";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Generate the new Organization_ID
if ($row['last_id']) {
    $lastIdNum = (int)substr($row['last_id'], 3); // Extract numeric part after 'ORG'
    $newIdNum = $lastIdNum + 1;
    $organizationID = 'ORG' . str_pad($newIdNum, 8, '0', STR_PAD_LEFT);
} else {
    $organizationID = 'ORG00000001'; // First organization
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $contactNo = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $registrationDate = date('Y-m-d');
    $campaigns = 0;
    $raisedAmount = 0;

    // Insert into the organizations table
    $sql = "INSERT INTO organization_profile (
                Organization_ID, Name, Address, Email, Website, Contact_No, Campaigns, Raised_Amount, Registration_Date, Username, Password
            ) VALUES (
                '$organizationID', '$name', '$address', '$email', '$website', '$contactNo', '$campaigns', '$raisedAmount', '$registrationDate', '$username', '$password'
            )";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Organization registered successfully.'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Organization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto 40px; /* Extra space at the bottom for button */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        p {
            text-align: center;
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="tel"], /* Ensures contact number box matches others */
        select,
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 15px; /* Push button a bit lower */
            background-color: #058717;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #045e12;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Organization Registration</h2>
        <form action="organization_registration.php" method="POST">
            <label for="name">Organization Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="website">Website:</label>
            <input type="text" id="website" name="website" required>

            <label for="contact_no">Contact Number:</label>
            <input type="tel" id="contact_no" name="contact_no" required>

            <input type="submit" value="Register">
        </form>
        <p><a href="index.php">Back to Login Page</a></p>
    </div>
</body>
</html>