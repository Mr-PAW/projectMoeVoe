<?php

// Array gambar + teks-nya
$slides = [
  [
    "image" => "img/main1.png",
    "link" => "index.php",
    "text"  => "MoeVoe"
  ],
  [
    "image" => "img/main4.png",
    "link" => "articles.php",
    "text"  => "Our latest article !"
  ],
  [
    "image" => "img/main5.png",
    "link" => "movie.php",
    "text"  => "Review the movie on your own !"
  ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .carousel {
      position: relative;
      width: 100%;
      height: 75vh; /* 60% tinggi layar */
      overflow: hidden;
    }

    .carousel img {

      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .carousel img.active {
      opacity: 1;
    }

    .carousel-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-shadow: 0 2px 8px rgba(0,0,0,0.7);
      font-size: 3rem;
      font-weight: bold;
      text-align: center;
      z-index: 20;
    }

    .arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.3);
      border: 2px solid black;
      color: white;
      font-size: 2rem;
      font-weight: bold;
      padding: 0.4rem 0.9rem;
      cursor: pointer;
      z-index: 30;
      border-radius: 50%;
      user-select: none;
      transition: background 0.3s;
    }

    .arrow:hover {
      background: rgba(255, 255, 255, 0.4);
      color: black;
    }

    .arrow.left {
      left: 20px;
    }

    .arrow.right {
      right: 20px;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- HEADER -->
  <?php include 'header.php'; ?>

  <!-- CAROUSEL -->
  <div class="carousel">
    <?php foreach ($slides as $index => $slide): ?>
      <a href="<?= htmlspecialchars($slide['link'] ?? '#') ?>">
        <img src="<?= htmlspecialchars($slide['image']) ?>" 
         alt="Slide <?= $index + 1 ?>" 
         class="<?= $index === 0 ? 'active' : '' ?>">
      </a>
    <?php endforeach; ?>


    <!-- TEKS DI TENGAH -->
    <div class="carousel-text" id="carouselText">
      <?= htmlspecialchars($slides[0]['text']) ?>
    </div>

    <!-- ARROW KIRI & KANAN -->
    <div class="arrow left" id="prev">&#10094;</div>
    <div class="arrow right" id="next">&#10095;</div>
  </div>

    <!-- TOP PICKS SECTION -->
  <section class="max-w-[1600px] mx-auto my-16 px-6">
    <h2 class="text-3xl font-bold text-purple-900 mb-8 text-center">Top Picks</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6">

      <?php
      include 'db_connect.php';
      $result = $conn->query("SELECT * FROM movie ORDER BY m_rating desc LIMIT 7");
      while ($row = $result->fetch_assoc()):
      ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
          <a href="review.php?id=<?= $row['m_id'] ?>">
            <img src="<?= htmlspecialchars($row['m_image']) ?>" 
                alt="<?= htmlspecialchars($row['m_name']) ?>" 
                class="w-full h-60 object-cover">
            <div class="p-3  text-center"> 
              <h3 class="text-md font-semibold text-gray-800 mb-3">
                <?= htmlspecialchars($row['m_name']) ?>
              </h3>
              <h3 class="text-md font-semibold text-gray-800">
                <?= htmlspecialchars($row['m_rating']) ?>
                ⭐
              </h3>
            </div>
          </a>
        </div>
      <?php endwhile; ?>

    </div>
  </section>

      <!-- OUR NEWEST ARTICLE SECTION -->
    <section class="max-w-[1600px] mx-auto my-20 px-6">
      <h2 class="text-3xl font-bold text-purple-900 mb-8 text-center">Our Newest Article</h2>

      <?php
        include 'db_connect.php';
        // Ambil 1 artikel terbaru + join ke nama author
        $articleQuery = $conn->query("
          SELECT a.*, acc.name AS author_name
          FROM articles a
          JOIN account acc ON a.author_id = acc.id
          ORDER BY a.created_at DESC
          LIMIT 1
        ");

        if ($articleQuery && $articleQuery->num_rows > 0):
          $article = $articleQuery->fetch_assoc();
      ?>
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl transition flex flex-col md:flex-row">
          <!-- Gambar Artikel -->
          <?php if (!empty($article['image'])): ?>
            <img src="<?= htmlspecialchars($article['image']) ?>"
                alt="<?= htmlspecialchars($article['title']) ?>"
                class="w-full md:w-1/3 h-72 object-cover">
          <?php else: ?>
            <div class="w-full md:w-1/3 h-72 bg-gray-300 flex items-center justify-center text-gray-600">
              No Image
            </div>
          <?php endif; ?>

          <!-- Isi Artikel -->
          <div class="p-6 flex flex-col justify-between md:w-2/3">
            <div>
              <h3 class="text-2xl font-semibold text-purple-800 mb-2">
                <?= htmlspecialchars($article['title']) ?>
              </h3>
              <p class="text-gray-600 mb-4">
                <span class="font-medium">By:</span> <?= htmlspecialchars($article['author_name']) ?>  
                | <span class="text-sm"><?= htmlspecialchars($article['created_at']) ?></span>
              </p>
              <p class="text-gray-700 mb-4 line-clamp-3">
                <?= nl2br(htmlspecialchars(substr($article['content'], 0, 200))) ?>...
              </p>
            </div>
            <a href="article_detail.php?id=<?= $article['id'] ?>" 
              class="mt-4 inline-block bg-purple-700 hover:bg-purple-800 text-white font-semibold py-2 px-4 rounded-lg transition">
              Read More →
            </a>
          </div>
        </div>

      <?php else: ?>
        <p class="text-center text-gray-600">No articles have been posted yet.</p>
      <?php endif; ?>
    </section>




  <!-- SECTION: Tentang Penulis -->
  <section class="max-w-[1600px] mx-auto my-16 px-6">
    <div class="flex flex-col md:flex-row items-center bg-white rounded-2xl shadow-lg p-6 md:p-10 gap-6">
      <img src="img/profile1.jpeg" alt="Penulis" class="w-40 h-40 rounded-full object-cover shadow-md">
      
      <div class="text-gray-700 md:ml-8">
        <h3 class="text-2xl font-semibold mb-2">Mas PAW</h3>
        <p class="text-lg leading-relaxed">
          Alhamdulillah web
          <span class="font-semibold text-purple-800">MoeVoe</span> 
          sudah jadi :)
          
        </p>
      </div>
    </div>
  </section>


  <script>
    // Ambil data teks dari PHP
    const texts = <?php echo json_encode(array_column($slides, 'text')); ?>;
    const slides = document.querySelectorAll('.carousel img');
    const textElement = document.getElementById('carouselText');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const links = <?php echo json_encode(array_column($slides, 'link')); ?>;
  const anchors = document.querySelectorAll('.carousel a');
    let current = 0;
    let interval;

  function showSlide(index) {
    slides[current].classList.remove('active');
    current = (index + slides.length) % slides.length;
    slides[current].classList.add('active');
    textElement.textContent = texts[current];

    // update link aktif
    anchors.forEach((a, i) => {
      a.style.pointerEvents = i === current ? "auto" : "none"; // cuma link aktif yang bisa diklik
    });
  }


    prevBtn.addEventListener('click', () => {
      showSlide(current - 1);
      resetInterval();
    });

    nextBtn.addEventListener('click', () => {
      showSlide(current + 1);
      resetInterval();
    });

    function startAutoSlide() {
      interval = setInterval(() => {
        showSlide(current + 1);
      }, 4000);
    }

    function resetInterval() {
      clearInterval(interval);
      startAutoSlide();
    }

    startAutoSlide();
  </script>

</body>
</html>
