<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assume user is logged in and email is stored in session
if (!isset($_SESSION['user_email'])) {
    echo "<p style='color:red;text-align:center;'>You must be logged in to receive notifications.</p>";
    exit;
}

$userEmail = $_SESSION['user_email'];

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for products with 20% discount
$sql = "SELECT product_name FROM discounts WHERE discount_percentage = 20";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product = $row['product_name'];

        // Email content
        $subject = "Special Offer: 20% Discount on $product!";
        $message = "Hello,\n\nGreat news! The product '$product' is now available at a 20% discount.\nVisit our website to grab the deal.\n\nThank you,\nSmart Offer Notification System";
        $headers = "From: no-reply@yourwebsite.com";

        // Send email
        if (mail($userEmail, $subject, $message, $headers)) {
            echo "<p style='color:green;text-align:center;'>Notification sent to $userEmail for $product.</p>";
        } else {
            echo "<p style='color:red;text-align:center;'>Failed to send email to $userEmail.</p>";
        }
    }
} else {
    echo "<p style='color:blue;text-align:center;'>No products currently at 20% discount.</p>";
}

$conn->close();
?>