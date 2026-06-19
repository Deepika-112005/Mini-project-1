<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'] ?? '';
    $discount = $_POST['discount'] ?? '';

    $conn = new mysqli("localhost", "root", "", "shopdb");
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $stmt = $conn->prepare("INSERT INTO discounts (product_name, discount_percentage) VALUES (?, ?)");
    $stmt->bind_param("si", $product, $discount);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Discount added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="POST">
  <label>Product Name:</label><br>
  <input type="text" name="product" required><br>
  <label>Discount Percentage:</label><br>
  <input type="number" name="discount" required><br><br>
  <input type="submit" value="Add Discount">
</form>