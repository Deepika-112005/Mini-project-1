<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "miniproject_db"); // adjust DB name

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get subscription JSON from frontend
$subscription = json_decode(file_get_contents("php://input"), true);

if (!$subscription) {
    http_response_code(400);
    echo "Invalid subscription data";
    exit;
}

// Prepare SQL
$stmt = $mysqli->prepare("INSERT INTO subscriptions (endpoint, p256dh, auth) VALUES (?, ?, ?)");
$stmt->bind_param(
    "sss",
    $subscription['endpoint'],
    $subscription['keys']['p256dh'],
    $subscription['keys']['auth']
);

if ($stmt->execute()) {
    echo "✅ Subscription saved successfully";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>