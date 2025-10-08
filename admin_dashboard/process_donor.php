<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // stored as plain text (as per your request)
    $contact_no = trim($_POST['contact_no']);
    $blood_group = $_POST['blood_group'];
    $profession = trim($_POST['profession']);
    $registration_date = date('Y-m-d');

    // Generate new Donor_ID (e.g., DNR00000001)
    $sql = "SELECT Donor_ID FROM donor_profile ORDER BY Donor_ID DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['Donor_ID'];
        $number = (int)substr($last_id, 3); // remove 'DNR'
        $new_number = $number + 1;
        $donor_id = 'DNR' . str_pad($new_number, 8, '0', STR_PAD_LEFT);
    } else {
        $donor_id = 'DNR00000001';
    }

    // Insert new donor
    $stmt = $conn->prepare("INSERT INTO donor_profile 
        (Donor_ID, Name, Username, Date_of_Birth, Gender, Address, Email, Password, Contact_No, Blood_Group, Profession, Contributed_Amount, Registration_Date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)");

    $stmt->bind_param("ssssssssssss", 
        $donor_id, $name, $username, $date_of_birth, $gender, $address, $email, $password, $contact_no, $blood_group, $profession, $registration_date);

    if ($stmt->execute()) {
        echo "<script>alert('Donor registration successful!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>