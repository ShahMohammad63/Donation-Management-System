<?php
include 'connect.php';
session_start();

// Ensure donor is logged in
if (!isset($_SESSION['donor_id'])) {
    echo "Donor not logged in.";
    exit();
}

$donor_id = $_SESSION['donor_id']; // Get donor ID from session

// Fetch the donor's donations from the database
$sql = "SELECT d.Donation_ID, d.Donation_Amount, d.Payment_Date, c.Title AS Campaign_Title
        FROM donation d
        JOIN campaign_profile c ON d.Campaign_ID = c.Campaign_ID
        WHERE d.Donor_ID = '$donor_id'";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "No donations found for this donor.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Donations</title>
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
        .pdf-button {
            background-color: #3498db;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .pdf-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Donations</h1>

    <table>
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Campaign Title</th>
                <th>Donation Amount</th>
                <th>Payment Date</th>
                <th>Download Receipt</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Donation_ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['Campaign_Title']); ?></td>
                    <td><?php echo htmlspecialchars($row['Donation_Amount']) . ' BDT'; ?></td>
                    <td><?php echo htmlspecialchars($row['Payment_Date']); ?></td>
                    <td>
                        <!-- Add PDF download link for each donation -->
                        <a href="receipt.php?donation_id=<?php echo urlencode($row['Donation_ID']); ?>" class="pdf-button" target="_blank">Download as PDF</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="back-button">
        <a href="donor_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>