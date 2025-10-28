<?php
include 'db_connect.php';
$id = $_GET['id'] ?? null;
if (!$id) header("Location: articles.php");

$article = mysqli_fetch_assoc(mysqli_query($conn, "SELECT a.*, account.name AS author 
                                                   FROM articles a 
                                                   LEFT JOIN account ON a.author_id = account.id 
                                                   WHERE a.id='$id'"));
if (!$article) header("Location: articles.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($article['title']) ?> | MoeVoe</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d001a] text-gray-100">
    <?php
    include 'header.php';  ?>
  <div class="max-w-4xl mx-auto py-12 px-6">
    <h1 class="text-4xl font-extrabold text-purple-400 mb-4"><?= htmlspecialchars($article['title']) ?></h1>
    <p class="text-gray-400 text-sm mb-6">
      By <?= htmlspecialchars($article['author'] ?? 'Admin') ?> • <?= date("d M Y", strtotime($article['created_at'])) ?>
    </p>

    <img src="<?= './' . $article['image'] ?>" class="rounded-lg mb-8 w-full shadow-lg">

    <article class="prose prose-lg prose-invert max-w-none">
      <?= nl2br(htmlspecialchars($article['content'])) ?>
    </article>

    <div class="mt-10">
      <a href="articles.php" class="text-purple-400 hover:text-purple-300 transition">&larr; Back to all articles</a>
    </div>
  </div>
</body>

</html>
