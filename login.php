<?php
session_start();
include 'db_connect.php';

$error = '';
$email = ''; // simpan email agar tidak hilang saat error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validasi format email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Alamat email tidak valid. Gunakan format seperti nama@email.com.";
  } elseif (strlen($password) < 6) {
    $error = "Password minimal harus 6 karakter.";
  } else {
    // Cek user di database
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        if ($user['role'] === 'admin') {
          header("Location: admin_dashboard.php");
        } else {
          header("Location: index.php");
        }
        exit;
      } else {
        $error = "Password salah!";
      }
    } else {
      $error = "Email tidak ditemukan!";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MoeVoe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('img/login1.png'); /* ganti sesuai lokasi gambarmu */
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
    .password-container {
      position: relative;
    }
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 65%;
      transform: translateY(-35%);
      cursor: pointer;
      color: #555 ;
    }
  </style>
</head>
<body class="relative flex items-center justify-center min-h-screen">

  <!-- Overlay hitam transparan -->
  <div class="overlay"></div>

  <!-- Card Login -->
  <div class="bg-sky-200 bg-opacity-95 backdrop-blur-md rounded-2xl shadow-2xl w-full max-w-md p-8 z-10">
    <h2 class="text-4xl font-bold text-center text-purple-900 mb-6">Login</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-sm">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['register_success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg text-sm">
            Registered successfully!
        </div>
        <?php unset($_SESSION['register_success']); ?>
    <?php endif; ?>


    <form method="POST" action="">
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="text" id="email" name="email"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          placeholder="blablabla@email.com" value="<?= htmlspecialchars($email) ?>" required>
      </div>

      <div class="mb-6 password-container">
        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
        <input type="password" id="password" name="password"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          placeholder="???" required>
        <span class="toggle-password" id="togglePassword">
          👁️
        </span>
      </div>

      <button type="submit"
        class="w-full bg-purple-900 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
        Masuk
      </button>
    </form>

    <p class="text-center text-gray-600 text-sm mt-6">
      Belum punya akun?
      <a href="register.php" class="text-purple-900 hover:underline font-medium">Daftar sekarang</a>
    </p>

    <p class="text-center text-gray-600 text-sm mt-1">
      Atau masuk sebagai 
      <a href="index.php" class="text-purple-900 hover:underline font-medium">tamu </a>
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
