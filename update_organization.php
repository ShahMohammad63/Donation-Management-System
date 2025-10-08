<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organizationId = $_POST['organization_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text as per request
    $email = $_POST['email'];
    $website = $_POST['website'];
    $contactNo = $_POST['contact_no'];
    $campaigns = $_POST['campaigns'];
    $raisedAmount = $_POST['raised_amount'];
    $registrationDate = $_POST['registration_date'];

    $sql = "UPDATE organization_profile SET 
                Name = '$name', 
                Address = '$address',
                Username = '$username',
                Password = '$password',
                Email = '$email', 
                Website = '$website', 
                Contact_No = '$contactNo',
                Campaigns = '$campaigns', 
                Raised_Amount = '$raisedAmount', 
                Registration_Date = '$registrationDate' 
            WHERE Organization_ID = '$organizationId'";

    if ($conn->query($sql) === TRUE) {
        header("Location: organizations.php");
        exit();
    } else {
        echo "Error updating organization: " . $conn->error;
    }
}

$conn->close();
?>