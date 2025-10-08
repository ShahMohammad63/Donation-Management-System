<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1 style="text-align: center;">Edit Campaign Profile</h1>
    <?php
    include 'connect.php';

    if (isset($_GET['id'])) {
        $campaignId = $_GET['id'];
        $sql = "SELECT * FROM campaign_profile WHERE Campaign_ID='$campaignId'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
    <form action="update_campaign.php" method="POST">
        Campaign ID: <input type="text" name="campaign_id" value="<?php echo htmlspecialchars($row['Campaign_ID']); ?>" readonly><br><br>
        Title: <input type="text" name="title" value="<?php echo htmlspecialchars($row['Title']); ?>"><br><br>
		Organization ID: <input type="text" name="organization_id" value="<?php echo htmlspecialchars($row['Organization_ID']); ?>"><br><br>
        Description: <input type="text" name="description" value="<?php echo htmlspecialchars($row['Description']); ?>"><br><br>
        Goal Amount: <input type="text" name="goal_amount" value="<?php echo htmlspecialchars($row['Goal_Amount']); ?>"><br><br>
        Raised Amount: <input type="text" name="raised_amount" value="<?php echo htmlspecialchars($row['Raised_Amount']); ?>"><br><br>
        Launch Date: <input type="date" name="launch_date" value="<?php echo date('Y-m-d', strtotime($row['Launch_Date'])); ?>"><br><br>

        <input type="submit" value="Save Changes">
    </form>
    <?php
        } else {
            echo "No campaign found with ID: " . htmlspecialchars($campaignId);
        }
    } else {
        echo "Campaign ID not provided.";
    }
    ?>
</div>
</body>
</html>