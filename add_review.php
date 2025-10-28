<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $m_id = (int)$_POST['m_id'];
  $user_id = $_SESSION['user_id'];
  $review = trim($_POST['review']);

  if (!empty($review)) {
    $stmt = $conn->prepare("INSERT INTO reviews (m_id, user_id, review) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $m_id, $user_id, $review);
    $stmt->execute();
  }
}

header("Location: review.php?id=" . $m_id);
exit;
?>
