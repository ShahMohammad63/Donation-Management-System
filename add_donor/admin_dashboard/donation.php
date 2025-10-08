<?php
include 'connect.php'; // Connects to the database

// Fetch all donations
$sql = "SELECT Donation_ID, Donor_ID, Campaign_ID, Donation_Amount, Payment_Date FROM donation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Donations - Streamlined Charity Fundraising Assistant</title>
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

    <h1>Donation Records</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Donor ID</th>
                    <th>Campaign ID</th>
                    <th>Donation Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Donation_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Donor_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Campaign_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Donation_Amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['Payment_Date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; margin-top: 20px; font-size: 18px; color: #888;">No donations found.</p>
    <?php endif; ?>
	<div class="navigation">
		<p><a href="admin_dashboard.php">Back to Dashboard</a></p>
	</div>

</body>
</html>