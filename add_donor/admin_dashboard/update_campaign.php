<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campaignId = $_POST['campaign_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $goalAmount = $_POST['goal_amount'];
    $raisedAmount = $_POST['raised_amount'];
    $launchDate = date('Y-m-d', strtotime($_POST['launch_date'])); // Format for SQL
    $organizationId = $_POST['organization_id'];  // New field for Organization ID

    // Corrected SQL query without a comment in the middle
    $sql = "UPDATE campaign_profile SET 
                Title=?, 
                Description=?, 
                Goal_Amount=?, 
                Raised_Amount=?, 
                Launch_Date=?, 
                Organization_ID=? 
            WHERE Campaign_ID=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $title, $description, $goalAmount, $raisedAmount, $launchDate, $organizationId, $campaignId);

    if ($stmt->execute()) {
        header("Location: campaigns.php");
        exit();
    } else {
        echo "Error updating campaign: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: edit_campaign.php?id=" . urlencode($_POST['campaign_id']));
    exit();
}
?>