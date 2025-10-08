<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donor Profile</title>
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
        select,
        input[type="date"],
        input[type="password"] {
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
        small {
            display: block;
            margin-top: -5px;
            margin-bottom: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 style="text-align: center;">Edit Donor Profile</h1>
        <?php
        include 'connect.php';
        if (isset($_GET['id'])) {
            $donorId = $_GET['id'];
            $sql = "SELECT * FROM donor_profile WHERE Donor_ID='$donorId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        <form action="update_donor.php" method="POST">
            Donor ID: <input type="text" name="donor_id" value="<?php echo $row['Donor_ID']; ?>" readonly><br><br>
            Name: <input type="text" name="name" value="<?php echo $row['Name']; ?>"><br><br>
            Date of Birth: <input type="date" name="date_of_birth" value="<?php echo $row['Date_of_Birth']; ?>"><br><br>
            Gender:
            <select name="gender">
                <?php
                    $genders = ["Male", "Female", "Other"];
                    foreach ($genders as $g) {
                        $selected = ($row['Gender'] == $g) ? 'selected' : '';
                        echo "<option value=\"$g\" $selected>$g</option>";
                    }
                ?>
            </select><br><br>
            Address: <input type="text" name="address" value="<?php echo $row['Address']; ?>"><br><br>
            Mobile No: <input type="text" name="contact_no" value="<?php echo $row['Contact_No']; ?>"><br><br>
            Contribution Amount: <input type="text" name="contributed_amount" value="<?php echo $row['Contributed_Amount']; ?>"><br><br>
			Username: <input type="text" name="username" value="<?php echo $row['Username']; ?>"><br><br>
            Email: <input type="text" name="email" value="<?php echo $row['Email']; ?>"><br><br>
            Password: 
            <input type="text" name="password" placeholder="Enter new password">
            Blood Group:
            <select name="blood_group">
                <?php
                    $bloodGroups = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"];
                    foreach ($bloodGroups as $group) {
                        $selected = ($row['Blood_Group'] == $group) ? 'selected' : '';
                        echo "<option value=\"$group\" $selected>$group</option>";
                    }
                ?>
            </select><br><br>
            Profession: <input type="text" name="profession" value="<?php echo $row['Profession']; ?>"><br><br>
            Registration Date: <input type="date" name="registration_date" value="<?php echo $row['Registration_Date']; ?>"><br><br>
            <input type="submit" value="Save Changes">
        </form>
        <?php
            } else {
                echo "No donor found with ID: $donorId";
            }
        } else {
            echo "Donor ID not provided.";
        }
        ?>
    </div>
</body>
</html>