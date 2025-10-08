<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_id            = $_POST['donor_id'];
    $name                = $_POST['name'];
    $dob                 = $_POST['date_of_birth'];
    $gender              = $_POST['gender'];
    $address             = $_POST['address'];
    $contributed_amount  = $_POST['contributed_amount'];
    $email               = $_POST['email'];
    $blood_group         = $_POST['blood_group'];
    $profession          = $_POST['profession'];
    $registration_date   = $_POST['registration_date'];
    $contact_no          = $_POST['contact_no'];
    $password            = $_POST['password']; // Plain-text password
    $username            = $_POST['username'];

    if (!empty($password)) {
        // Update all fields including password
        $sql = "UPDATE donor_profile SET 
                    Name = ?, 
                    Date_of_Birth = ?, 
                    Gender = ?, 
                    Address = ?, 
                    Contributed_Amount = ?, 
                    Email = ?, 
                    Blood_Group = ?, 
                    Profession = ?, 
                    Registration_Date = ?, 
                    Contact_No = ?, 
                    Password = ?, 
                    Username = ?
                WHERE Donor_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdsssssssi", 
            $name, $dob, $gender, $address, $contributed_amount, $email, 
            $blood_group, $profession, $registration_date, $contact_no, 
            $password, $username, $donor_id);

    } else {
        // Update all fields except password
        $sql = "UPDATE donor_profile SET 
                    Name = ?, 
                    Date_of_Birth = ?, 
                    Gender = ?, 
                    Address = ?, 
                    Contributed_Amount = ?, 
                    Email = ?, 
                    Blood_Group = ?, 
                    Profession = ?, 
                    Registration_Date = ?, 
                    Contact_No = ?, 
                    Username = ?
                WHERE Donor_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdssssssi", 
            $name, $dob, $gender, $address, $contributed_amount, $email, 
            $blood_group, $profession, $registration_date, $contact_no, 
            $username, $donor_id);
    }

    if ($stmt->execute()) {
        header("Location: donors.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>