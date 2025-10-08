<?php
session_start();
include 'connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Admin login
    if ($_POST["username"] === "admin" && $_POST["password"] === "admin123") {
        header("Location: admin_dashboard.php");
        exit;

    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Check donor login
        $sql_donor = "SELECT Donor_ID, Username, Password FROM donor_profile WHERE Username = ?";
        $stmt_donor = $conn->prepare($sql_donor);
        $stmt_donor->bind_param("s", $username);
        $stmt_donor->execute();
        $stmt_donor->store_result();
        $stmt_donor->bind_result($donor_id, $db_donor_username, $db_donor_password);

        if ($stmt_donor->num_rows > 0) {
            $stmt_donor->fetch();
            if ($password === $db_donor_password) {
                $_SESSION['donor_id'] = $donor_id;
                $_SESSION['username'] = $db_donor_username;
                header("Location: donor_dashboard.php");
                exit;
            } else {
                echo '<script>alert("Invalid username or password"); window.location.href = "index.php";</script>';
                exit;
            }
        }
        $stmt_donor->close();

        // Check organization login
        $sql_org = "SELECT Organization_ID, Username, Password FROM organization_profile WHERE Username = ?";
        $stmt_org = $conn->prepare($sql_org);
        $stmt_org->bind_param("s", $username);
        $stmt_org->execute();
        $stmt_org->store_result();
        $stmt_org->bind_result($org_id, $db_org_username, $db_org_password);

        if ($stmt_org->num_rows > 0) {
            $stmt_org->fetch();
            if ($password === $db_org_password) {
                $_SESSION['organization_id'] = $org_id;
                $_SESSION['username'] = $db_org_username;
                header("Location: organization_dashboard.php");
                exit;
            } else {
                echo '<script>alert("Invalid username or password"); window.location.href = "index.php";</script>';
                exit;
            }
        }
        $stmt_org->close();

        // If not found in any role
        echo '<script>alert("Invalid username or password"); window.location.href = "index.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Streamlined Charity Fundraising Assistant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
