<?php
session_start();
$conn = new mysqli("localhost", "root", "", "shopdb");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $username, $db_password);
    $stmt->fetch();
    if (password_verify($password, $db_password)) {
        $_SESSION['admin_id'] = $id;
        $_SESSION['admin_username'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "<p style='color:red;'>Invalid password.</p>";
    }
} else {
    echo "<p style='color:red;'>Admin not found.</p>";
}
?>