<!-- admin_sidebar.php -->
<div class="w-64 bg-gray-900 text-white flex flex-col p-5">
  <div class="text-2xl font-bold mb-6 text-center">🎬 MoeVoe</div>

  <div class="flex flex-col items-center text-purple-300 mb-6">
      <h2 class="text-sm uppercase tracking-wider mb-2">Admin Dashboard</h2>
      <a href="index.php" class="text-sm text-indigo-500 hover:text-white transition">View Home Page</a>
      <a href="logout.php" class="text-sm text-red-400 hover:text-white transition">Logout</a>
      
  </div>

  <nav class="flex flex-col gap-2">
      <a href="admin_dashboard.php" 
         class="px-4 py-2 rounded-lg font-semibold transition
                <?= basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php' ? 'bg-purple-600' : 'hover:bg-purple-700' ?>">
          🎞 Movies
      </a>

      <a href="admin_article.php" 
         class="px-4 py-2 rounded-lg font-semibold transition
                <?= basename($_SERVER['PHP_SELF']) === 'admin_article.php' ? 'bg-purple-600' : 'hover:bg-purple-700' ?>">
          📄 Articles
      </a>
  </nav>
</div>
