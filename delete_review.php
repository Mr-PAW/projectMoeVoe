<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$r_id = $_GET['r_id'];
$m_id = $_GET['m_id'];

$stmt = $conn->prepare("DELETE FROM reviews WHERE r_id=? AND user_id=?");
$stmt->bind_param("ii", $r_id, $_SESSION['user_id']);
$stmt->execute();

header("Location: review.php?id=$m_id");
exit;
?>
