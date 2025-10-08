<?php
// Include the database connection file
include 'connect.php';

// Check if the donor ID is provided as a GET parameter
if (isset($_GET['id'])) {
    // Sanitize the input
    $donorId = mysqli_real_escape_string($conn, $_GET['id']);

    // Correct column name: Donor_ID (not donor_ID)
    $sql = "DELETE FROM donor_profile WHERE Donor_ID = '$donorId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Show alert and redirect using JavaScript
        echo "<script>alert('Donor deleted successfully.'); window.location.href = 'donors.php';</script>";
    } else {
        echo "Error deleting donor: " . mysqli_error($conn);
    }
} else {
    // No ID provided
    echo "<script>alert('No donor ID provided.'); window.location.href = 'donors.php';</script>";
}

// Close connection
mysqli_close($conn);
?>