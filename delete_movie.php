<?php
session_start();
include 'db_connect.php';

// Cek login & role admin
if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  echo "Unauthorized";
  exit;
}

$user_id = $_SESSION['user_id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM account WHERE id='$user_id'"));
if ($u['role'] !== 'admin') {
  http_response_code(403);
  echo "Access denied";
  exit;
}

// Cek apakah ada parameter ID
if (!isset($_GET['id'])) {
  http_response_code(400);
  echo "Missing movie ID";
  exit;
}

$id = intval($_GET['id']);

// Ambil data film (buat hapus juga file gambar kalau ada)
$res = mysqli_query($conn, "SELECT m_image FROM movie WHERE m_id='$id'");
$movie = mysqli_fetch_assoc($res);

if (!$movie) {
  http_response_code(404);
  echo "Movie not found";
  exit;
}

// Hapus file gambar dari server jika ada
if (!empty($movie['m_image']) && file_exists($movie['m_image'])) {
  unlink($movie['m_image']);
}

// Hapus dari database
mysqli_query($conn, "DELETE FROM movie WHERE m_id='$id'");

// Jika pemanggilan lewat AJAX, kirim JSON
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
  echo json_encode(['status' => 'success']);
  exit;
}

// Kalau bukan AJAX, redirect biasa
header("Location: admin_dashboard.php");
exit;
?>
