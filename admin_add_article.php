<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$user_id = $_SESSION['user_id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM account WHERE id='$user_id'"));
if ($u['role'] !== 'admin') header("Location: index.php");

// Edit mode
$edit = isset($_GET['edit']) ? $_GET['edit'] : null;
$data = null;
if ($edit) {
  $res = mysqli_query($conn, "SELECT * FROM articles WHERE id='$edit'");
  $data = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $path = $data ? $data['image'] : '';

  if (empty($title) || empty($content)) {
    echo "<script>alert('Title dan Content wajib diisi');history.back();</script>";
    exit;
  }

  // Upload image jika ada
  if (!empty($_FILES['image']['name'])) {
    $filename = time() . "_" . basename($_FILES['image']['name']);
    $path = "img/articles/" . $filename;
    move_uploaded_file($_FILES['image']['tmp_name'], $path);
  }

  // Insert atau Update pakai prepared statement
  if ($edit) {
    $stmt = $conn->prepare("UPDATE articles SET title=?, content=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $path, $edit);
  } else {
    $stmt = $conn->prepare("INSERT INTO articles (title, content, author_id, image, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssis", $title, $content, $user_id, $path);
  }

  if ($stmt->execute()) {
    header("Location: admin_article.php");
    exit;
  } else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data: " . addslashes($stmt->error) . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $edit ? "Edit Article" : "Add Article" ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6"><?= $edit ? "Edit Article" : "Add New Article" ?></h2>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input name="title" class="w-full p-2 border rounded" placeholder="Article Title"
             value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>

      <textarea name="content" rows="12" class="w-full p-2 border rounded" 
                placeholder="Write your article here..." required><?= htmlspecialchars($data['content'] ?? '') ?></textarea>

      <input type="file" name="image" accept="image/*" class="w-full">
      <?php if ($data && $data['image']): ?>
        <img src="<?= $data['image'] ?>" class="w-40 mt-2 rounded border">
      <?php endif; ?>

      <div class="flex justify-end gap-3 pt-4">
        <a href="admin_article.php" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</a>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
          <?= $edit ? "Update" : "Create" ?>
        </button>
      </div>
    </form>
  </div>
</body>
</html>
