<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Profile</title>
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
    <h1>Campaign Profile</h1>
    <table>
        <tr>
            <th>Campaign ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Launch Date</th>
            <th>Action</th>
        </tr>
        <?php
        // Include the database connection file
        include 'connect.php';

        // SQL query to retrieve campaign profiles
        $sql = "SELECT * FROM campaign_profile";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Campaign_ID"]. "</td>";
                echo "<td>" . $row["Title"]. "</td>";      
                echo "<td>" . $row["Description"]. "</td>";
                echo "<td>" . $row["Launch_Date"]. "</td>";
                echo "<td>
                    <div class='dropdown'>
                        <button class='dropbtn'>Action</button>
                        <div class='dropdown-content'>
                            <a href='donate_campaign.php?campaign_id=" . $row['Campaign_ID'] . "'>Donate Now</a>
                        </div>
                    </div>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No campaigns available</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
    <div class="navigation">
        <p><a href="donor_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>