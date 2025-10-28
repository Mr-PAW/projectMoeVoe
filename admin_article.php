<?php
session_start();
include 'db_connect.php';

// Cek login & role admin
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$user_id = $_SESSION['user_id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM account WHERE id='$user_id'"));
if ($u['role'] !== 'admin') header("Location: index.php");

// Ambil data artikel
$articles = mysqli_query($conn, "SELECT a.*, account.name AS author 
                                FROM articles a 
                                LEFT JOIN account ON a.author_id = account.id 
                                ORDER BY a.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MoeVoe | Admin Article Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-100 text-gray-800">

  <!-- Sidebar -->
  <?php include 'admin_sidebar.php'; ?>

  <!-- Main -->
  <div class="flex-1 p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Article List</h1>
      <div class="flex items-center gap-3">
        <span class="font-semibold">Hi, Admin <?= htmlspecialchars($u['name']) ?> 👋</span>
        <a href="admin_add_article.php" 
           class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">+ Add Article</a>
      </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <?php while ($row = mysqli_fetch_assoc($articles)): ?>
        <div class="flex justify-between items-center border-b p-4 hover:bg-gray-50 transition">
          <div>
            <p class="font-semibold text-gray-800"><?= htmlspecialchars($row['title']) ?></p>
            <p class="text-gray-500 text-sm">
              <?= htmlspecialchars($row['author'] ?? 'Admin') ?> · 
              <?= date("d M Y", strtotime($row['created_at'])) ?>
            </p>
          </div>

          <div class="flex gap-3">
            <a href="admin_add_article.php?edit=<?= $row['id'] ?>" 
               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
            <a href="admin_delete_article.php?id=<?= $row['id'] ?>" 
               onclick="return confirm('Delete this article?')" 
               class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

</body>
</html>
