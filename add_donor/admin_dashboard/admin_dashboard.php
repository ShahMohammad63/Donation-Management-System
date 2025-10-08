<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Information - Streamlined Charity Fundraising Assistant</title>
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
                <div class="sidebar-info-block"><a href="campaigns.php">Campaign List</a></div>
                <hr>
                <li><h3>Donors</h3></li>
                <div class="sidebar-info-block"><a href="donors.php">Donor List</a></div>
				<div class="sidebar-info-block"><a href="donation.php">View Donations</a></div>
                <hr>
                <!-- Organizations Section -->
                <li><h3>Organizations</h3></li>
                <div class="sidebar-info-block"><a href="organizations.php">Organization List</a></div>
                <hr>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="admin-section">
            <div class="admin-dropdown">
                <span style="color: #fff;">Administrator ▼</span>
                <div class="admin-dropdown-content">
                    <a href="index.php">Logout</a>
                </div>
            </div>
        </div>
        <h1>Welcome to Streamlined Charity Fundraising Assistant - Admin Panel</h1>
        <div class="info-blocks">
            <div class="info-block">
                <h2>Total Campaigns</h2>
                <?php
                $hostname = "localhost";
                $username = "root";
                $password = "";
                $database = "streamline";
                $conn = mysqli_connect($hostname, $username, $password, $database);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $campaignCountQuery = "SELECT COUNT(*) AS total_campaigns FROM campaign_profile";
                $campaignCountResult = mysqli_query($conn, $campaignCountQuery);
                $campaignCountRow = mysqli_fetch_assoc($campaignCountResult);
                $totalcampaigns = $campaignCountRow['total_campaigns'];
                echo "<p>$totalcampaigns</p>";
                mysqli_close($conn);
                ?>
            </div>
            <div class="info-block">
                <h2>Total Donors</h2>
                <?php
                $conn = mysqli_connect($hostname, $username, $password, $database);
                $donorCountQuery = "SELECT COUNT(*) AS total_donors FROM donor_profile";
                $donorCountResult = mysqli_query($conn, $donorCountQuery);
                $donorCountRow = mysqli_fetch_assoc($donorCountResult);
                $totaldonors = $donorCountRow['total_donors'];
                echo "<p>$totaldonors</p>";
                mysqli_close($conn);
                ?>
            </div>
            <!-- Organizations Info Block -->
            <div class="info-block">
                <h2>Total Organizations</h2>
                <?php
                $conn = mysqli_connect($hostname, $username, $password, $database);
                $organizationCountQuery = "SELECT COUNT(*) AS total_organizations FROM organization_profile";
                $organizationCountResult = mysqli_query($conn, $organizationCountQuery);
                $organizationCountRow = mysqli_fetch_assoc($organizationCountResult);
                $totalorganizations = $organizationCountRow['total_organizations'];
                echo "<p>$totalorganizations</p>";
                mysqli_close($conn);
                ?>
            </div>
            <img src="Giving.jpg" alt="School Icon" style="width: 1670px; height: 531px; margin-top: 220px; margin-left:-1205px">
        </div>
    </div>
    <footer style="text-align: center; padding: 1px; background-color: #f4f4f4;">
        <p>Copyright © 2025. All rights reserved.</p>
    </footer>
</body>
</html>