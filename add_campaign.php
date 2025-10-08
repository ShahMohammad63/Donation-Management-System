<?php
session_start(); // Start the session to access session variables
// Check if organization_id is set in session
if (!isset($_SESSION['organization_id']) || empty($_SESSION['organization_id'])) {
    die("Organization ID is missing. Please log in.");
}

$organization_id = $_SESSION['organization_id'];

// Connect to the database
include 'connect.php';

// Fetch the latest campaign_id from the campaign_profile table
$query = "SELECT MAX(campaign_id) AS latest_campaign_id FROM campaign_profile";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Generate the next campaign_id by incrementing the latest campaign_id
$campaign_id = isset($row['latest_campaign_id']) ? $row['latest_campaign_id'] + 1 : 1; // Start from 1 if no campaigns exist
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Campaign</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        p {
            text-align: center;
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #058717;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #045e12;
        }
        .success-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Campaign</h2>
        <form id="add-campaign-form" action="process_campaign.php" method="post">
            <!-- Hidden field to auto-fill organization_id -->
            <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>" required>
            
            <!-- Hidden field to auto-fill campaign_id -->
            <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>" required>
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>
            
            <label for="goal_amount">Goal Amount:</label>
            <input type="text" id="goal_amount" name="goal_amount" required>

            <input type="submit" value="Finish">
        </form>
    </div>
    <p><a href="organization_dashboard.php">Cancel</a></p>
</body>
</html>