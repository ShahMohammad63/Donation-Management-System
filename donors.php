<?php
include 'connect.php';
$sql = "SELECT * FROM donor_profile";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Profile</title>
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
    <h1>Donor Profile</h1>
    <table>
        <tr>
            <th>Donor ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Contributed Amount</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>Mobile No</th>
            <th>Blood Group</th>
            <th>Profession</th>
            <th>Registration Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Donor_ID"] . "</td>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td>" . $row["Date_of_Birth"] . "</td>";
                echo "<td>" . $row["Gender"] . "</td>";
                echo "<td>" . $row["Address"] . "</td>";
                echo "<td>" . $row["Contributed_Amount"] . "</td>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["Password"] . "</td>";
                echo "<td>" . $row["Contact_No"] . "</td>";
                echo "<td>" . $row["Blood_Group"] . "</td>";
                echo "<td>" . $row["Profession"] . "</td>";
                echo "<td>" . $row["Registration_Date"] . "</td>";
                echo "<td>
                    <div class='dropdown'>
                        <button class='dropbtn'>Actions</button>
                        <div class='dropdown-content'>
                            <a href='edit_donor.php?id=" . urlencode($row['Donor_ID']) . "'>Edit</a>
                            <a href='#' onclick='confirmDelete(\"" . addslashes($row['Donor_ID']) . "\")'>Delete</a>
                        </div>
                    </div>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='14'>No donor records found.</td></tr>";
        }
        ?>
    </table>

    <div class="navigation">
        <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
    </div>

    <script>
        function confirmDelete(donorId) {
            if (confirm("Are you sure you want to delete this donor record?")) {
                window.location.href = "delete_donor.php?id=" + encodeURIComponent(donorId);
            }
        }
    </script>
</body>
</html>