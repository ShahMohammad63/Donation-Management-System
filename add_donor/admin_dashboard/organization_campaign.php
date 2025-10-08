<?php
session_start();
include 'connect.php';

// Check if the organization is logged in
if (!isset($_SESSION['organization_id'])) {
    header("Location: login.php");
    exit();
}

$organization_id = $_SESSION['organization_id'];

// Fetch campaigns launched by the organization
$sql = "SELECT * FROM campaign_profile WHERE Organization_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $organization_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Campaigns - Streamlined Charity Fundraising Assistant</title>
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

<h1>Your Launched Campaigns</h1>

<table>
    <tr>
        <th>Campaign ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Goal Amount</th>
        <th>Raised Amount</th>
        <th>Launch Date</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Campaign_ID']}</td>
                    <td>{$row['Title']}</td>
                    <td>{$row['Description']}</td>
                    <td>{$row['Goal_Amount']}</td>
                    <td>{$row['Raised_Amount']}</td>
                    <td>{$row['Launch_Date']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No campaigns found.</td></tr>";
    }
    $stmt->close();
    $conn->close();
    ?>
</table>

<div class="navigation">
    <a href="organization_dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>