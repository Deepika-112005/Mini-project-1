<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}
?>
<h2>Welcome, Admin <?php echo $_SESSION['admin_username']; ?></h2>
<a href="add_discount.php">Add Discount</a> |
<a href="view_discounts.php">View Discounts</a> |
<a href="logout.php">Logout</a>