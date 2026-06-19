<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h2 style='text-align:center;color:blue;'>This page only accepts form submissions.</h2>";
    echo "<div style='text-align:center;'><a href='feedback.html'>Go to Feedback Form</a></div>";
    exit;
}

$name        = $_POST['name'] ?? '';
$email       = $_POST['email'] ?? '';
$preferences = $_POST['preferences'] ?? '';
$interests   = $_POST['interests'] ?? '';

if ($name === '' || $email === '') {
    echo "<p style='color:red;text-align:center;'>Name and Email are required.</p>";
    exit;
}

$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO feedback(name, email, preferences, interests) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $preferences, $interests);

if ($stmt->execute()) {
    echo "<h2 style='color:green;text-align:center;'>Feedback submitted successfully!</h2>";
} else {
    echo "<p style='color:red;text-align:center;'>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>