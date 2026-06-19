<?php
$conn = new mysqli("localhost", "root", "", "login");

$email = "test@example.com";
$password = password_hash("123456", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

echo "✅ Test user inserted.";
?>