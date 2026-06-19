<?php
$hashed = password_hash("admin123", PASSWORD_DEFAULT);
$conn = new mysqli("localhost", "root", "", "shopdb");
$conn->query("DELETE FROM admin WHERE username='admin'"); // optional cleanup
$conn->query("INSERT INTO admin (username, password) VALUES ('admin', '$hashed')");
echo "✅ Admin inserted.";
?>