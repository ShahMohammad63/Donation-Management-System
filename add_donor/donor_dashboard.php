<?php
session_start();
include 'connect.php';

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['donor_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in donor's ID from the session
$donor_id = $_SESSION['donor_id'];

// Query the database for the donor's information
$sql = "SELECT * FROM donor_profile WHERE Donor_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $donor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Store donor info in variables
    $donor_name = $row['Name'];
    $donor_username = $row['Username'];
    $donor_email = $row['Email'];
    $donor_contributed_amount = $row['Contributed_Amount']; // Make sure this field exists
} else {
    echo "No donor found.";
}

// Get the number of unique campaigns the donor has donated to
$campaignQuery = "SELECT COUNT(DISTINCT Campaign_ID) AS total_campaigns FROM donation WHERE Donor_ID = ?";
$campaignStmt = $conn->prepare($campaignQuery);
$campaignStmt->bind_param("s", $donor_id);
$campaignStmt->execute();
$campaignResult = $campaignStmt->get_result();
$campaignRow = $campaignResult->fetch_assoc();
$totalCampaigns = $campaignRow['total_campaigns'];

// Get the total contributed amount
$donationQuery = "SELECT SUM(Donation_Amount) AS total_contributed FROM donation WHERE Donor_ID = ?";
$donationStmt = $conn->prepare($donationQuery);
$donationStmt->bind_param("s", $donor_id);
$donationStmt->execute();
$donationResult = $donationStmt->get_result();
$donationRow = $donationResult->fetch_assoc();
$totalContributedAmount = $donationRow['total_contributed'];

// Close the prepared statements
$stmt->close();
$campaignStmt->close();
$donationStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - Streamlined Charity Fundraising Assistant</title>
    <style>     
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100%;
            background-color: #058717;
            padding-top: 20px;
            text-align: center;
            overflow-y: auto;
        }
        .sidebar-content {
            min-height: 100%;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            margin-bottom: 50px;
        }
        .sidebar li {
            padding: 10px 20px;
        }
        .sidebar h3 {
            color: #fff;
            margin-top: 0px;
            margin-bottom: 10px;
            margin-left: -9px;
            font-size: 30px;
        }
        .sidebar hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }
        .sidebar li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar li a:hover {
            background-color: #555;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .content h1 {
            color: #333;
        }
        .admin-section {
            background-color: #555;
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            margin-left: 9px;
            position: relative;
        }
        .admin-dropdown {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
        }
        .admin-dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .admin-dropdown:hover .admin-dropdown-content {
            display: block;
        }
        .admin-dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .admin-dropdown-content a:hover {
            background-color: #555;
        }
        .admin-link {
            color: #fff;
            text-decoration: none;
        }
        .admin-link:hover {
            color: #fff;
        }
        h1 {
            margin-left: 11px;
        }
        P {
            font-family: Arial, sans-serif;
            font-size: 30px;
        }
        .info-blocks {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }
        .info-block {
            width: 360px;
            height: 150px;
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-right: 8px;
            margin-left: 13px;
        }
        .info-block:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .info-block h2 {
            margin-top: 13;
        }
        .info-block p {
            margin-bottom: 0;
        }
        .sidebar-info-blocks {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-top: 20px;
            padding-left: 29px;
        }
        .sidebar-info-block {
            width: 190px;
            height: 40px;
            background-color: #333;
            border-radius: 10px;
            margin-bottom: 10px;
            margin-left: 29px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .sidebar-info-block a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar-info-block a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-content">
            <ul>
                <li><h3>Dashboard</h3></li>
                <hr>
                <li><h3>Campaigns</h3></li>
                <div class="sidebar-info-block"><a href="donor_campaigns.php">Campaign List</a></div>
                <hr>
                <li><h3>Leaderboard</h3></li>
                <div class="sidebar-info-block"><a href="leaderboard.php">View Leaderboard</a></div>
                <hr>
                <li><h3>Your Donations</h3></li>
                <div class="sidebar-info-block"><a href="donor_donations.php">View Donations</a></div>
                <hr>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="admin-section">
            <div class="admin-dropdown">
                <span style="color: #fff;">Donor ▼</span>
                <div class="admin-dropdown-content">
                    <a href="index.php">Logout</a>
                </div>
            </div>
        </div>
        <h1>Welcome to Streamlined Charity Fundraising Assistant - <?php echo $donor_name?></h1>
        <div class="info-blocks">
            <div class="info-block">
                <h2>Your Campaigns</h2>
                <p><?php echo $totalCampaigns; ?></p>
            </div>
            <div class="info-block">
                <h2>Your Contributed Amount</h2>
                <p><?php echo $totalContributedAmount; ?></p>
            </div>
            <img src="Giving.jpg" alt="School Icon" style="width: 1670px; height: 531px; margin-top: 220px; margin-left:-800px">
        </div>
    </div>
    <footer style="text-align: center; padding: 1px; background-color: #f4f4f4;">
        <p>Copyright © 2025. All rights reserved.</p>
    </footer>
</body>
</html>