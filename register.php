<?php
include 'db_connect.php';
session_start();

$error = '';
$success = '';
$name = ''; // added

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $name = trim($_POST['name']); // added
  $password = trim($_POST['password']);
  $role = 'user'; // default user biasa

  // Validasi format email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Alamat email tidak valid. Gunakan format seperti nama@email.com.";
  } elseif (empty($name)) {
    $error = "Nama wajib diisi.";
  } elseif (strlen($name) > 30) {
    $error = "Nama maksimal 30 karakter.";
  } elseif (strlen($password) < 6) {
    $error = "Password minimal harus 6 karakter.";
  } else {
    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $error = "Email sudah terdaftar! Gunakan email lain.";
    } else {
      // Hash password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Simpan ke database (tambahkan name)
      $stmt = $conn->prepare("INSERT INTO account (name, email, password, role) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
      if ($stmt->execute()) {
        $_SESSION['register_success'] = true;
        header("Location: login.php");
        exit;
      } else {
        $error = "Terjadi kesalahan saat registrasi. Coba lagi.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MoeVoe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('img/register1.png'); 
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    .overlay {
      background: rgba(0, 0, 0, 0.5);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
    .toggle-password {
        top: 65%;
        transform: translateY(-35%);
        position: absolute;
        right: 12px;
    }
  </style>
</head>
<body class="relative flex items-center justify-center min-h-screen">

  <!-- Overlay hitam transparan -->
  <div class="overlay"></div>

  <!-- Card Register -->
  <div class="bg-sky-200 bg-opacity-95 backdrop-blur-md rounded-2xl shadow-2xl w-full max-w-md p-8 z-10">
    <h2 class="text-4xl font-bold text-center text-purple-900 mb-6">Register</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-sm">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="text" id="email" name="email"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          placeholder="blablabla@email.com" required
          value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
      </div>

      <!-- New name field (placed below email) -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
        <input type="text" id="name" name="name" maxlength="30"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          placeholder="Nama (maks 30 karakter)" required
          value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
      </div>

      <div class="mb-6">
        <div class="relative">
        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
        <input type="password" id="password" name="password"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10"
            placeholder="???????(6)" required>
        <span class="toggle-password" id="togglePassword">
          👁️
        </span>
        </div>
      </div>

      <button type="submit"
        class="w-full bg-purple-900 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
        Daftar
      </button>
    </form>

    <p class="text-center text-gray-600 text-sm mt-6">
      Sudah punya akun?
      <a href="login.php" class="text-purple-900 hover:underline font-medium">Masuk sekarang</a>
    </p>
  </div>

  <script>
    // Fungsi toggle show/hide password
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
    });
  </script>

</body>
</html>
