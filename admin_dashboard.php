<?php
session_start();
include 'db_connect.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$userQuery = "SELECT name, role FROM account WHERE id = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Cegah akses jika bukan admin
if ($user['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

// Ambil data movie
$query = "SELECT m_id, m_name, m_genre, m_image FROM movie ORDER BY m_name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoeVoe Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-100 text-gray-800">

  <!-- Sidebar -->
    <?php include 'admin_sidebar.php'; ?>



<!-- Main -->
    <div class="flex-1 p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Movie List</h1>
        <div class="flex items-center gap-3">
        <span class="font-semibold">Hi, Admin <?= htmlspecialchars($user['name']) ?> 👋</span>
        <a href="admin_movie.php" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Movie</a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="flex justify-between items-center border-b p-4 hover:bg-gray-50">
            <div class="flex items-center gap-4">
            <img src="<?= htmlspecialchars($row['m_image']) ?>" class="w-16 h-24 rounded object-cover">
            <div>
                <p class="font-semibold"><?= htmlspecialchars($row['m_name']) ?></p>
                <p class="text-gray-500 text-sm"><?= htmlspecialchars($row['m_genre']) ?></p>
            </div>
            </div>

            <div class="flex gap-3">
                <a href="admin_movie.php?edit=<?= $row['m_id'] ?>" 
                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                <a href="delete_movie.php?id=<?= $row['m_id'] ?>"
                    onclick="return confirm('Are you sure you want to delete this movie?');"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                <a href="admin_view_reviews.php?m_id=<?= $row['m_id'] ?>" 
                    class="bg-pink-600 text-white px-3 py-1 rounded hover:bg-pink-700">View Reviews</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    </div>


</body>
</html>
