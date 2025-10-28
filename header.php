<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<header class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-md">
  <div class="max-w-7xl mx-auto px-1 py-3 flex justify-between items-center">
    
    <!-- Logo -->
    <a href="index.php" class="text-white text-2xl font-extrabold tracking-wide">
      MoeVoe
    </a>

    <!-- Navigation -->
    <nav class="hidden md:flex items-center space-x-8">
      <a href="index.php" class="text-white hover:text-blue-200 transition">Home</a>
      <a href="movie.php" class="text-white hover:text-blue-200 transition">Movies</a>
      <a href="articles.php" class="text-white hover:text-blue-200 transition">Articles</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="flex items-center space-x-4 ml-4">
          <!-- Hi user -->
          <span class="text-white bg-blue-900/50 px-3 py-1 rounded-lg font-semibold shadow-sm">
            Hi, <span class="text-blue-200"><?= htmlspecialchars($_SESSION['user_name']) ?> 👋</span>
          </span>

          <!-- Tombol Admin Dashboard (jika admin) -->
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php" 
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium px-4 py-1.5 rounded-lg transition shadow-md">
               Admin Dashboard
            </a>
          <?php endif; ?>

          <!-- Tombol Logout -->
          <a href="logout.php" 
             class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-1.5 rounded-lg transition shadow-md">
             Logout
          </a>
        </div>
      <?php else: ?>
        <div class="flex items-center space-x-3 ml-4">
          <a href="login.php" 
             class="bg-lime-500 hover:bg-lime-600 text-white font-medium px-4 py-1.5 rounded-lg transition shadow-md">
             Login
          </a>
          <a href="register.php" 
             class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-1.5 rounded-lg transition shadow-md">
             Register
          </a>
        </div>
      <?php endif; ?>
    </nav>
  </div>
</header>
        