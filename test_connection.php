<?php
$mysqli = new mysqli("localhost", "root", "", "miniproject_db");

if ($mysqli->connect_error) {
    die("DB connection failed: " . $mysqli->connect_error);
}
echo "✅ Connected successfully to miniproject_db";
?>