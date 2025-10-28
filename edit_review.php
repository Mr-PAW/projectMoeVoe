<?php
include 'db_connect.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
  exit;
}

// Ambil data
$r_id = isset($_POST['r_id']) ? (int)$_POST['r_id'] : 0;
$new_review = isset($_POST['review']) ? trim($_POST['review']) : '';

if ($r_id <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid review ID.']);
  exit;
}

if (strlen($new_review) === 0) {
  echo json_encode(['success' => false, 'message' => 'Review cannot be empty.']);
  exit;
}

if (strlen($new_review) > 2000) {
  echo json_encode(['success' => false, 'message' => 'Review too long (max 2000 chars).']);
  exit;
}

// Cek apakah review milik user yang login
$check = $conn->prepare("SELECT user_id FROM reviews WHERE r_id = ?");
$check->bind_param("i", $r_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows === 0) {
  echo json_encode(['success' => false, 'message' => 'Review not found.']);
  exit;
}

$row = $res->fetch_assoc();
if ((int)$row['user_id'] !== (int)$_SESSION['user_id']) {
  echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
  exit;
}

// Update review
$stmt = $conn->prepare("UPDATE reviews SET review = ? WHERE r_id = ? AND user_id = ?");
$stmt->bind_param("sii", $new_review, $r_id, $_SESSION['user_id']);
if ($stmt->execute()) {
  echo json_encode(['success' => true, 'message' => 'Review updated successfully.', 'review' => $new_review]);
} else {
  echo json_encode(['success' => false, 'message' => 'Database error.']);
}
