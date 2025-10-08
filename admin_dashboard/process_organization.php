<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "streamline";

    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Organization details from form
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $contactNo = $_POST['contact_no'];
    $campaigns = $_POST['campaigns'];
    $raisedAmount = $_POST['raised_amount'];
    $registrationDate = date('Y-m-d');

    // Login credentials
    $orgUsername = $_POST['org_username'];
    $orgPassword = $_POST['org_password']; // NOTE: Password is stored as-is, not hashed

    // Get the last inserted Organization_ID
    $getLastIdQuery = "SELECT MAX(Organization_ID) AS last_id FROM organization_profile";
    $result = mysqli_query($conn, $getLastIdQuery);
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['last_id'];
    $organizationID = $lastId ? $lastId + 1 : 1;

    // Insert organization into the database
    $sql = "INSERT INTO organization_profile 
        (Organization_ID, Name, Address, Email, Website, Contact_No, Campaigns, Raised_Amount, Registration_Date, Org_Username, Org_Password)
        VALUES 
        ('$organizationID', '$name', '$address', '$email', '$website', '$contactNo', '$campaigns', '$raisedAmount', '$registrationDate', '$orgUsername', '$orgPassword')";

    if (mysqli_query($conn, $sql)) {
        $source = $_POST['source']; // To check if the request is coming from admin or elsewhere
        if ($source == "admin") {
            echo "<script>alert('Organization added successfully.'); window.location.href = 'organizations.php';</script>";
        } else {
            echo "<script>alert('Organization registration successful!'); window.location.href = 'index.php';</script>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>