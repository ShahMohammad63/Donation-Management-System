<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['organization_id']) || empty($_SESSION['organization_id'])) {
    die("Organization ID is missing. Please log in.");
}

$organization_id = $_SESSION['organization_id'];

$query = "
    SELECT d.donation_id, d.donor_id, d.campaign_id, d.donation_amount, d.payment_date
    FROM donation d
    JOIN campaign_profile c ON d.campaign_id = c.campaign_id
    WHERE c.organization_id = '$organization_id'
    ORDER BY d.payment_date DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organization Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #058717;
        }
        a:hover {
            text-decoration: underline;
        }
        .navigation {
            text-align: center;
            margin-top: 20px;
        }
        .delete-btn {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #d43f3a;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropbtn {
            background-color: #3498db;
            color: white;
            padding: 8px;
            border: none;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown:hover .dropbtn {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <h1>Donations to Your Campaigns</h1>

    <table>
        <tr>
            <th>Donation ID</th>
            <th>Donor ID</th>
            <th>Campaign ID</th>
            <th>Donation Amount</th>
            <th>Payment Date</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['donation_id']}</td>";
                echo "<td>{$row['donor_id']}</td>";
                echo "<td>{$row['campaign_id']}</td>";
                echo "<td>{$row['donation_amount']}</td>";
                echo "<td>{$row['payment_date']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No donations found for your campaigns.</td></tr>";
        }
        ?>
    </table>
	  <div class="navigation">
        <p><a href="organization_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>