<?php
// discount.php

// Database connection settings
$servername = "localhost";   // Host name (usually 'localhost' in XAMPP)
$username = "root";          // Database username
$password = "";              // Database password
$dbname = "smartoffersystem";   // Same database name you used earlier

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data from POST
$discountName = $_POST['discountName'];
$discountType = $_POST['discountType'];
$discountValue = $_POST['discountValue'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$products = $_POST['products'];

// Simple validation
if (empty($discountName) || empty($discountType) || empty($discountValue)) {
  echo "Please fill in all required fields!";
  exit;
}

// Prepare SQL query
$sql = "INSERT INTO discounts (discount_name, discount_type, discount_value, start_date, end_date, products)
        VALUES ('$discountName', '$discountType', '$discountValue', '$startDate', '$endDate', '$products')";

// Run query
if ($conn->query($sql) === TRUE) {
  echo "<h2>Discount added successfully!</h2>";
  echo "<a href='feedback.html'>Go to Feedback Form</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>

