<?php
include 'connect.php';
session_start();

// Ensure donor is logged in
if (!isset($_SESSION['donor_id'])) {
    echo "Donor not logged in.";
    exit();
}

$donor_id = $_SESSION['donor_id']; // Get donor ID from session

if (!isset($_GET['campaign_id'])) {
    echo "Invalid campaign.";
    exit();
}

$campaign_id = $_GET['campaign_id'];

// Get campaign info (for title display)
$sql = "SELECT * FROM campaign_profile WHERE Campaign_ID = '$campaign_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Campaign not found.";
    exit();
}

$row = $result->fetch_assoc();
$title = $row['Title'];
$raised_amount = $row['Raised_Amount'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donation_amount = $_POST['donation_amount'];

    if (!is_numeric($donation_amount) || $donation_amount <= 0) {
        echo "Invalid donation amount.";
        exit();
    }

    // Generate new Donation_ID
    $query = "SELECT Donation_ID FROM donation ORDER BY Donation_ID DESC LIMIT 1";
    $res = $conn->query($query);

    if ($res->num_rows > 0) {
        $last_id = $res->fetch_assoc()['Donation_ID'];
        $num = (int)substr($last_id, 3) + 1;
    } else {
        $num = 1;
    }

    $new_donation_id = 'DON' . str_pad($num, 8, '0', STR_PAD_LEFT);
    $payment_date = date('Y-m-d');

    // Insert into donation table
    $stmt = $conn->prepare("INSERT INTO donation (Donation_ID, Donor_ID, Campaign_ID, Donation_Amount, Payment_Date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $new_donation_id, $donor_id, $campaign_id, $donation_amount, $payment_date);

    if ($stmt->execute()) {
        // Update raised amount for the campaign
        $new_raised_amount = $raised_amount + $donation_amount;
        $conn->query("UPDATE campaign_profile SET Raised_Amount = '$new_raised_amount' WHERE Campaign_ID = '$campaign_id'");

        // Update the donor's contributed amount
        $donor_sql = "SELECT Contributed_Amount FROM donor_profile WHERE Donor_ID = '$donor_id'";
        $donor_result = $conn->query($donor_sql);
        $donor_row = $donor_result->fetch_assoc();

        $current_contributed_amount = $donor_row['Contributed_Amount'];
        $new_contributed_amount = $current_contributed_amount + $donation_amount;

        // Update Contributed_Amount in donor_profile table
        $conn->query("UPDATE donor_profile SET Contributed_Amount = '$new_contributed_amount' WHERE Donor_ID = '$donor_id'");

        // Redirect to receipt page
        header("Location: receipt.php?donation_id=$new_donation_id");
        exit();
    } else {
        echo "Error inserting donation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donate to Campaign</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; }
        .form-container {
            width: 40%; margin: 40px auto; background: white;
            padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; }
        label, input, button {
            display: block; width: 100%; margin-bottom: 15px;
        }
        input {
            padding: 10px; border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            background: #3498db; color: white;
            border: none; padding: 10px;
            border-radius: 4px; cursor: pointer;
        }
        button:hover { background: #2980b9; }
    </style>
</head>
<body>

    <h1>Donate to: <?php echo htmlspecialchars($title); ?></h1>

    <div class="form-container">
        <form method="POST">
            <label for="donation_amount">Donation Amount (BDT):</label>
            <input type="number" name="donation_amount" id="donation_amount" required min="1" step="any" placeholder="Enter amount">

            <button type="submit">Donate</button>
        </form>
    </div>

</body>
</html>