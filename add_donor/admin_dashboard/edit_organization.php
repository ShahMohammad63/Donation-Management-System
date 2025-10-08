<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organization Profile</title>
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
            width: 400px;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="password"],
        select {
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
        <h1 style="text-align: center;">Edit Organization Profile</h1>
        <?php
        include 'connect.php';
        if (isset($_GET['id'])) {
            $organizationId = $_GET['id'];
            $sql = "SELECT * FROM organization_profile WHERE Organization_ID='$organizationId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        <form action="update_organization.php" method="POST">
            Organization ID: <input type="text" name="organization_id" value="<?php echo $row['Organization_ID']; ?>" readonly><br><br>
            Name: <input type="text" name="name" value="<?php echo $row['Name']; ?>"><br><br>
            Address: <input type="text" name="address" value="<?php echo $row['Address']; ?>"><br><br>
            Username: <input type="text" name="username" value="<?php echo $row['Username']; ?>"><br><br>
            Email: <input type="text" name="email" value="<?php echo $row['Email']; ?>"><br><br>
			Password: <input type="password" name="password" value="<?php echo $row['Password']; ?>"><br><br>
            Website: <input type="text" name="website" value="<?php echo $row['Website']; ?>"><br><br>
            Contact No: <input type="text" name="contact_no" value="<?php echo $row['Contact_No']; ?>"><br><br>
            Campaigns: <input type="text" name="campaigns" value="<?php echo $row['Campaigns']; ?>"><br><br>
            Raised Amount: <input type="number" name="raised_amount" value="<?php echo $row['Raised_Amount']; ?>"><br><br>
            Registration Date: <input type="date" name="registration_date" value="<?php echo $row['Registration_Date']; ?>"><br><br>
            <input type="submit" value="Save Changes">
        </form>
        <?php
            } else {
                echo "No organization found with ID: $organizationId";
            }
        } else {
            echo "Organization ID not provided.";
        }
        ?>
    </div>
</body>
</html>