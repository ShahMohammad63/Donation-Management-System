<?php
// Include the database connection file
include 'connect.php';
// Check if the campaign ID is provided as a GET parameter
if(isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $campaignId = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete the campaign record
    $sql = "DELETE FROM campaign_profile WHERE campaign_ID = '$campaignId'";
    // Execute the query
    if(mysqli_query($conn, $sql)) {
        // Record deleted successfully, redirect back to the campaign list page
        header("Location: campaigns.php");
        exit; // Stop further execution
    } else {
        // Error occurred while deleting the record
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect back to the campaign list page if no campaign ID is provided
    header("Location: campaigns.php");
    exit; // Stop further execution
}
// Close the database connection
mysqli_close($conn);
?>