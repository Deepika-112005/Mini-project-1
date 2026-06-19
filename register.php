<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h2 style='text-align:center;color:blue;'>This page only accepts form submissions.</h2>";
    echo "<div style='text-align:center;'><a href='register.html'>Go to Registration Form</a></div>";
    exit;
}

// Collect inputs
$name     = $_POST['name'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$gender   = $_POST['gender'] ?? '';

// Basic validation
if ($name === '' || $email === '' || $password === '' || $gender === '') {
    echo "<p style='color:red;text-align:center;'>All fields are required.</p>";
    exit;
}

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepared insert
$stmt = $conn->prepare("INSERT INTO users (name, email, password, gender) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo "<p style='color:red;text-align:center;'>Prepare failed: " . $conn->error . "</p>";
    $conn->close();
    exit;
}

$stmt->bind_param("ssss", $name, $email, $hashedPassword, $gender);

if ($stmt->execute()) {
    echo "<h2 style='color:green;text-align:center;'>Registration successful!</h2>";
    echo "<div style='text-align:center;'><a href='login.html'>Login here</a></div>";
} else {
    echo "<p style='color:red;text-align:center;'>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>