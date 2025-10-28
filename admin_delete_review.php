<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) header("Location: login.php");
$uid = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM account WHERE id='$uid'"));
if ($user['role'] !== 'admin') header("Location: index.php");

$id = $_GET['id'] ?? 0;
$m_id = $_GET['m_id'] ?? 0;

mysqli_query($conn, "DELETE FROM reviews WHERE r_id='$id'");
header("Location: admin_view_reviews.php?m_id=$m_id");
exit;
?>
