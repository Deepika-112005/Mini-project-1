<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h2 style='text-align:center;color:blue;'>This page only accepts form submissions.</h2>";
    echo "<div style='text-align:center;'><a href='login.html'>Go to Login Form</a></div>";
    exit;
}

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo "<p style='color:red;text-align:center;'>Email and Password are required.</p>";
    exit;
}

// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check user by email
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // Verify password
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        echo "<h2 style='color:green;text-align:center;'>Login successful!</h2>";
        echo "<div style='text-align:center;'><a href='discount.html'>Go to Discounts Page</a></div>";
    } else {
        echo "<p style='color:red;text-align:center;'>Invalid password.</p>";
    }
} else {
    echo "<p style='color:red;text-align:center;'>No account found with that email.</p>";
}

$stmt->close();
$conn->close();
?>