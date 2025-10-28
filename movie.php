<?php
include 'db_connect.php';
session_start();

// Pagination
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search dan Filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';

// --- sebelum filter dimulai ---
$sql = "SELECT * FROM movie WHERE 1=1";
$params = [];
$types = "";

// Filter nama
if (!empty($search)) {
  $sql .= " AND m_name LIKE ?";
  $params[] = "%$search%";
  $types .= "s";
}

// Filter genre
if (!empty($genre)) {
  $sql .= " AND m_genre = ?";
  $params[] = $genre;
  $types .= "s";
}

// Hitung total data
$count_sql = $sql;
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
  $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_result = $count_stmt->get_result();
$total_rows = $total_result->num_rows;
$total_pages = ceil($total_rows / $limit);

// Tambah limit & offset ke query utama
$sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii"; // <- DITAMBAH, bukan diganti!

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Genre list untuk filter dropdown
$genres = ["animation", "action", "horror", "comedy", "mystery", "live action", "series"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Movie - MoeVoe</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <?php include 'header.php'; ?>

  <div class="max-w-6xl mx-auto mt-10 px-4">
    <h1 class="text-4xl font-bold text-purple-900 mb-6 text-center">🎬 All Movies</h1>

    <!-- Filter & Search -->
    <form method="GET" class="flex flex-wrap items-center justify-between gap-3 mb-8 bg-white p-4 rounded-xl shadow">
      <div class="flex gap-3">
        <input type="text" name="search" placeholder="Search movie..." value="<?= htmlspecialchars($search) ?>"
               class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <select name="genre" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
          <option value="">All Genres</option>
          <?php foreach ($genres as $g): ?>
            <option value="<?= $g ?>" <?= $genre === $g ? 'selected' : '' ?>><?= ucfirst($g) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex items-center gap-3">
        <label class="text-gray-700 font-medium">Show:</label>
        <select name="limit" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
          <?php foreach ([4,8,12,16,20] as $l): ?>
            <option value="<?= $l ?>" <?= $limit == $l ? 'selected' : '' ?>><?= $l ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="bg-purple-900 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Filter</button>
      </div>
    </form>

    <!-- Movie Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition p-3">
            <a href="review.php?id=<?= $row['m_id'] ?>">
              <img src="<?= htmlspecialchars($row['m_image']) ?>" alt="<?= htmlspecialchars($row['m_name']) ?>"
                   class="rounded-xl h-64 w-full object-cover">
              <h2 class="text-lg font-semibold mt-3 text-center text-gray-800"><?= htmlspecialchars($row['m_name']) ?></h2>
              
              <p class="text-center text-sm text-gray-600 italic"><?= ucfirst($row['m_genre']) ?></p>
              <h3 class="text-md font-semibold text-right mr-3 mt-3 text-gray-800"><?= htmlspecialchars($row['m_rating']) ?>⭐</h3>
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="col-span-full text-center text-gray-500">No movies found.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center gap-3 mt-8 mb-8">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>&genre=<?= $genre ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-indigo-200 text-indigo-900 rounded-lg hover:bg-indigo-300 transition">Previous</a>
      <?php endif; ?>

      <span class="text-gray-700 font-medium">Page <?= $page ?> of <?= $total_pages ?></span>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>&genre=<?= $genre ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-indigo-200 text-indigo-900 rounded-lg hover:bg-indigo-300 transition">Next</a>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
