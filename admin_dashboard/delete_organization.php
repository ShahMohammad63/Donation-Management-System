<?php
// Include the database connection file
include 'connect.php';

// Check if the organization ID is provided as a GET parameter
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $organizationId = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete the organization record
    $sql = "DELETE FROM organization_profile WHERE Organization_ID = '$organizationId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Record deleted successfully, redirect back to the organization list page
        header("Location: organizations.php");
        exit; // Stop further execution
    } else {
        // Error occurred while deleting the record
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect back to the organization list page if no ID is provided
    header("Location: organizations.php");
    exit; // Stop further execution
}

// Close the database connection
mysqli_close($conn);
?>