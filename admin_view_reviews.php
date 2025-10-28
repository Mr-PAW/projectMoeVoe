<?php
session_start();
include 'db_connect.php';

// pastikan admin
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$uid = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM account WHERE id='$uid'"));
if ($user['role'] !== 'admin') header("Location: index.php");

// ambil movie & review
$m_id = $_GET['m_id'] ?? 0;
$movie = mysqli_fetch_assoc(mysqli_query($conn, "SELECT m_name FROM movie WHERE m_id='$m_id'"));
$q = "
  SELECT r.review, r.r_id AS review_id, a.name AS user_name
  FROM reviews r
  JOIN account a ON r.user_id = a.id
  WHERE r.m_id = '$m_id'
";
$res = mysqli_query($conn, $q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">
      Reviews for “<?= htmlspecialchars($movie['m_name']) ?>”
    </h2>

    <?php if (mysqli_num_rows($res) > 0): ?>
      <?php while ($r = mysqli_fetch_assoc($res)): ?>
        <div class="flex justify-between items-start border-b py-3">
          <div>
            <p class="font-semibold text-gray-700"><?= htmlspecialchars($r['user_name']) ?></p>
            <p class="text-gray-600"><?= htmlspecialchars($r['review']) ?></p>
          </div>
          <a href="admin_delete_review.php?id=<?= $r['review_id'] ?>&m_id=<?= $m_id ?>"
             onclick="return confirm('Yakin hapus review ini?')" 
             class="text-red-600 hover:text-red-800 font-medium">Delete</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-gray-500">Belum ada review untuk film ini.</p>
    <?php endif; ?>

    <div class="mt-6 text-right">
      <a href="admin_dashboard.php" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">Back</a>
    </div>
  </div>
</body>
</html>
