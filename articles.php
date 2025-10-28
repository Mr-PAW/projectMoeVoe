<?php
include 'db_connect.php';
$articles = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MoeVoe | Articles</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d001a] text-white">
    <?php
    include 'header.php';
    ?>
  <div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-4xl font-bold mb-10 text-purple-400">🎬 MoeVoe Articles</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php while ($a = mysqli_fetch_assoc($articles)): ?>
        <a href="article_detail.php?id=<?= $a['id'] ?>" 
           class="group block bg-[#1a0033] rounded-xl overflow-hidden shadow-lg 
                  hover:scale-105 hover:shadow-purple-500/30 transition duration-300">
          <img src="<?= './' . $a['image'] ?>" alt="<?= htmlspecialchars($a['title']) ?>" 
               class="w-full h-56 object-cover group-hover:opacity-80 transition">
          <div class="p-4">
            <h2 class="text-xl font-bold text-purple-400 mb-2 group-hover:text-purple-300">
              <?= htmlspecialchars($a['title']) ?>
            </h2>
            <p class="text-gray-400 text-sm line-clamp-3">
              <?= htmlspecialchars(substr(strip_tags($a['content']), 0, 150)) ?>...
            </p>
            <span class="text-gray-500 text-xs block mt-3">
              <?= date("d M Y", strtotime($a['created_at'])) ?>
            </span>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</body>

</html>
