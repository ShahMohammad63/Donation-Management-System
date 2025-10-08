<?php
session_start();
include 'connect.php';

// Check if the organization_id is available in session
if (!isset($_SESSION['organization_id']) || empty($_SESSION['organization_id'])) {
    die("Organization ID is missing. Please log in.");
}

$organization_id = $_SESSION['organization_id'];

// Get the data from the form
$campaign_id = $_POST['campaign_id']; // This comes from the hidden field
$title = mysqli_real_escape_string($conn, $_POST['title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$goal_amount = mysqli_real_escape_string($conn, $_POST['goal_amount']);

// Set the raised_amount to 0 initially
$raised_amount = 0;

// Get the current date for the launch date
$launch_date = date("Y-m-d");

// Prepare the SQL query to insert the campaign data
$query = "INSERT INTO campaign_profile (campaign_id, organization_id, title, description, goal_amount, raised_amount, launch_date)
          VALUES ('$campaign_id', '$organization_id', '$title', '$description', '$goal_amount', '$raised_amount', '$launch_date')";

// Execute the query
if (mysqli_query($conn, $query)) {
    // If the query is successful, redirect to the dashboard or show a success message
    header("Location: organization_dashboard.php");
    exit;
} else {
    // If there's an error, show the error message
    echo "<p>Error: " . mysqli_error($conn) . "</p>";
}
?>