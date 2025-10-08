<?php
include 'connect.php';
session_start();

// Ensure donor is logged in
if (!isset($_SESSION['donor_id'])) {
    echo "Donor not logged in.";
    exit();
}

// Fetch all donors and their total donation amount from Contributed_Amount
$sql = "SELECT Donor_ID, Name, Contributed_Amount 
        FROM donor_profile
        WHERE Contributed_Amount > 0
        ORDER BY Contributed_Amount DESC"; // Sort donors by contributed amount in descending order

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "No donations found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            color: green;
        }
        .back-button a {
            text-decoration: none;
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>⭐ Leaderboard ⭐</h1>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Donor Name</th>
                <th>Total Donations (BDT)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1; // Initialize rank counter
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Contributed_Amount']) . " BDT</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="back-button">
        <a href="donor_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>