<?php
include 'connect.php';
session_start();

// Ensure donor is logged in
if (!isset($_SESSION['donor_id'])) {
    echo "Donor not logged in.";
    exit();
}

// Get the donation ID from the URL
if (!isset($_GET['donation_id'])) {
    echo "Invalid donation ID.";
    exit();
}

$donation_id = $_GET['donation_id'];

// SQL query to get donation details
$sql = "SELECT * FROM donation WHERE Donation_ID = '$donation_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Donation not found.";
    exit();
}

$row = $result->fetch_assoc();
$donor_id = $row['Donor_ID'];
$campaign_id = $row['Campaign_ID'];
$donation_amount = $row['Donation_Amount'];
$payment_date = $row['Payment_Date'];

// Fetch the campaign title
$campaign_sql = "SELECT Title FROM campaign_profile WHERE Campaign_ID = '$campaign_id'";
$campaign_result = $conn->query($campaign_sql);
$campaign_row = $campaign_result->fetch_assoc();
$campaign_title = $campaign_row['Title'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generate PDF receipt when button is clicked
    require('fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(200, 10, 'Donation Receipt', 0, 1, 'C');
    $pdf->Ln(10);

    // Donation details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Donation ID:', 0, 0);
    $pdf->Cell(150, 10, $donation_id, 0, 1);

    $pdf->Cell(40, 10, 'Donor ID:', 0, 0);
    $pdf->Cell(150, 10, $donor_id, 0, 1);

    $pdf->Cell(40, 10, 'Campaign ID:', 0, 0);
    $pdf->Cell(150, 10, $campaign_id, 0, 1);

    $pdf->Cell(40, 10, 'Campaign Title:', 0, 0);
    $pdf->Cell(150, 10, $campaign_title, 0, 1);

    $pdf->Cell(40, 10, 'Donation Amount:', 0, 0);
    $pdf->Cell(150, 10, $donation_amount . ' BDT', 0, 1);

    $pdf->Cell(40, 10, 'Payment Date:', 0, 0);
    $pdf->Cell(150, 10, $payment_date, 0, 1);

    // Output the PDF
    $pdf->Output('I', 'donation_receipt_' . $donation_id . '.pdf');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .receipt-details {
            margin-bottom: 20px;
            text-align: left;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .back-to-campaigns {
            color: green;
            text-decoration: none;
            font-size: 16px;
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Donation Receipt</h1>

    <table>
        <tr>
            <th>Donation ID</th>
            <td><?php echo $donation_id; ?></td>
        </tr>
        <tr>
            <th>Donor ID</th>
            <td><?php echo $donor_id; ?></td>
        </tr>
        <tr>
            <th>Campaign ID</th>
            <td><?php echo $campaign_id; ?></td>
        </tr>
        <tr>
            <th>Campaign Title</th>
            <td><?php echo $campaign_title; ?></td>
        </tr>
        <tr>
            <th>Donation Amount</th>
            <td><?php echo $donation_amount . ' BDT'; ?></td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td><?php echo $payment_date; ?></td>
        </tr>
    </table>

    <div class="button-container">
        <!-- Form to trigger PDF generation -->
        <form method="POST">
            <button type="submit" class="btn">Download as PDF</button>
        </form>
    </div>
</div>

<a href="donor_campaigns.php" class="back-to-campaigns">Back to Campaigns</a>

</body>
</html>