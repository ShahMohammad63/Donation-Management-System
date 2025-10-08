<?php
session_start();
include 'connect.php';

// Check if the organization is logged in
if (!isset($_SESSION['organization_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in organization's ID
$organization_id = $_SESSION['organization_id'];

// Fetch organization details
$sql = "SELECT * FROM organization_profile WHERE Organization_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $organization_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $org_name = $row['Name'];
    $org_username = $row['Username'];
    $org_email = $row['Email'];
    $org_raised_amount = $row['Raised_Amount']; // ensure this column exists
} else {
    echo "No organization found.";
}
$stmt->close();

// Fetch number of donors for the organization's campaigns
$donorCountQuery = "
    SELECT COUNT(DISTINCT donor_profile.Donor_ID) AS total_donors
    FROM donation 
    JOIN donor_profile ON donation.Donor_ID = donor_profile.Donor_ID
    JOIN campaign_profile ON donation.Campaign_ID = campaign_profile.Campaign_ID
    WHERE campaign_profile.Organization_ID = ?
";
$donorCountStmt = $conn->prepare($donorCountQuery);
$donorCountStmt->bind_param("s", $organization_id);
$donorCountStmt->execute();
$donorCountResult = $donorCountStmt->get_result();
$donorCountRow = $donorCountResult->fetch_assoc();
$donorCountStmt->close();

// Fetch raised amount for the organization's campaigns
$raisedAmountQuery = "
    SELECT SUM(Donation_Amount) AS total_raised_amount
    FROM donation 
    JOIN campaign_profile ON donation.Campaign_ID = campaign_profile.Campaign_ID
    WHERE campaign_profile.Organization_ID = ?
";
$raisedAmountStmt = $conn->prepare($raisedAmountQuery);
$raisedAmountStmt->bind_param("s", $organization_id);
$raisedAmountStmt->execute();
$raisedAmountResult = $raisedAmountStmt->get_result();
$raisedAmountRow = $raisedAmountResult->fetch_assoc();
$raisedAmountStmt->close();

$raisedAmount = $raisedAmountRow['total_raised_amount'] ? $raisedAmountRow['total_raised_amount'] : 0; // Default to 0 if no donations
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard - Streamlined Charity Fundraising Assistant</title>
    <style>
        /* SAME STYLES AS DONOR DASHBOARD */
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
        p {
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
            font-size: 14px;
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
                <div class="sidebar-info-block"><a href="organization_campaign.php">View Campaigns</a></div>
                <div class="sidebar-info-block"><a href="add_campaign.php">Launch Campaign</a></div>
                <hr>
                <li><h3>Donations</h3></li>
                <div class="sidebar-info-block"><a href="organization_donations.php">View Donations</a></div>
                <hr>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="admin-section">
            <div class="admin-dropdown">
                <span style="color: #fff;">Organization ▼</span>
                <div class="admin-dropdown-content">
                    <a href="index.php">Logout</a>
                </div>
            </div>
        </div>
        <h1>Welcome to Streamlined Charity Fundraising Assistant - <?php echo $org_name; ?></h1>
        <div class="info-blocks">
            <div class="info-block">
                <h2>Your Campaigns</h2>
                <?php
                $campaignCountQuery = "SELECT COUNT(*) AS total_campaigns FROM campaign_profile WHERE Organization_ID = ?";
                $campaignCountStmt = $conn->prepare($campaignCountQuery);
                $campaignCountStmt->bind_param("s", $organization_id);
                $campaignCountStmt->execute();
                $campaignCountResult = $campaignCountStmt->get_result();
                $campaignCountRow = $campaignCountResult->fetch_assoc();
                echo "<p>{$campaignCountRow['total_campaigns']}</p>";
                $campaignCountStmt->close();
                ?>
            </div>
            <div class="info-block">
                <h2>Your Donors</h2>
                <p><?php echo $donorCountRow['total_donors']; ?></p>
            </div>
            <div class="info-block">
                <h2>Your Raised Amount</h2>
                <p><?php echo $raisedAmount; ?></p>
            </div>
        </div>
        <img src="Giving.jpg" alt="School Icon" style="width: 1620px; height: 531px; margin-top: 30px; margin-left: 13px">
    </div>
</body>
</html>