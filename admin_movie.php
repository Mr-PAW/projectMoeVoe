<?php
session_start();
include 'db_connect.php';

// Cek login & role admin
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
$user_id = (int)$_SESSION['user_id'];
$u_res = mysqli_query($conn, "SELECT * FROM account WHERE id = $user_id");
$u = mysqli_fetch_assoc($u_res);
if (!$u || $u['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

// Mode edit
$edit = isset($_GET['edit']) ? (int)$_GET['edit'] : null;
$data = null;
if ($edit) {
  $stmt = $conn->prepare("SELECT * FROM movie WHERE m_id = ?");
  $stmt->bind_param("i", $edit);
  $stmt->execute();
  $res = $stmt->get_result();
  $data = $res->fetch_assoc();
  $stmt->close();
}

// Helper: safe filename
function safe_filename($name) {
  $name = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $name);
  return $name;
}

// Proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil & trim input
  $name     = trim($_POST['m_name'] ?? '');
  $rating   = trim($_POST['m_rating'] ?? '');
  $directed = trim($_POST['m_directed'] ?? '');
  $genre    = trim($_POST['m_genre'] ?? '');
  $desc     = trim($_POST['m_desc'] ?? '');

  // Validasi dasar
  if ($name === '' || $rating === '' || $directed === '' || $genre === '' || $desc === '') {
    echo "<script>alert('Semua field wajib diisi.');history.back();</script>";
    exit;
  }

  // Validasi rating: 1-2 digit optionally one decimal (uses dot)
  if (!preg_match('/^(10|[0-9]{1,2})(\.[0-9])?$/', $rating)) {
    echo "<script>alert('Rating harus berupa angka 0-10, maksimal 1 desimal (contoh: 8 atau 8.9).');history.back();</script>";
    exit;
  }

  // cast rating ke float
  $rating_val = (float) str_replace(',', '.', $rating); // also tolerate comma by converting, but earlier we validated dot
  if ($rating_val < 0 || $rating_val > 10) {
    echo "<script>alert('Rating harus antara 0 sampai 10.');history.back();</script>";
    exit;
  }

  // Handle file upload
  $image_path = $data['m_image'] ?? ''; // default: current image (for edit)
  if (!empty($_FILES['m_image']['name'])) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $orig_name = basename($_FILES['m_image']['name']);
    $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
      echo "<script>alert('Tipe file tidak diperbolehkan. Gunakan: jpg, jpeg, png, gif, webp.');history.back();</script>";
      exit;
    }

    // pastikan folder ada
    $targetDir = __DIR__ . "/img/movie/";
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0755, true);
    }

    $safe = time() . "_" . safe_filename($orig_name);
    $targetPath = $targetDir . $safe;

    if (!move_uploaded_file($_FILES['m_image']['tmp_name'], $targetPath)) {
      echo "<script>alert('Gagal mengunggah gambar.');history.back();</script>";
      exit;
    }
    // simpan path relatif dari root project (sesuaikan bila perlu)
    $image_path = "img/movie/" . $safe;
  } else {
    // jika create dan tidak ada file -> block
    if (!$edit) {
      echo "<script>alert('Gambar wajib diunggah.');history.back();</script>";
      exit;
    }
    // edit & tidak upload -> keep $image_path = existing
  }

  // Simpan ke DB (prepared statements)
  if ($edit) {
    $stmt = $conn->prepare("UPDATE movie SET m_name = ?, m_rating = ?, m_directed = ?, m_genre = ?, m_desc = ?, m_image = ? WHERE m_id = ?");
    // types: s d s s s s i  => but bind_param supports: s (string), d (double), i (int)
    $stmt->bind_param("sdssssi", $name, $rating_val, $directed, $genre, $desc, $image_path, $edit);
    $ok = $stmt->execute();
    $stmt->close();
  } else {
    $stmt = $conn->prepare("INSERT INTO movie (m_name, m_rating, m_directed, m_genre, m_desc, m_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssss", $name, $rating_val, $directed, $genre, $desc, $image_path);
    $ok = $stmt->execute();
    $stmt->close();
  }

  if ($ok) {
    header("Location: admin_dashboard.php");
    exit;
  } else {
    // jika gagal, hapus file baru yang ter-upload (jika ada dan sedang create atau replace)
    if (!empty($targetPath) && file_exists($targetPath)) {
      @unlink($targetPath);
    }
    echo "<script>alert('Terjadi kesalahan saat menyimpan data.');history.back();</script>";
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $edit ? "Edit Movie" : "Add Movie" ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800"><?= $edit ? "Edit Movie" : "Add New Movie" ?></h2>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input name="m_name" class="w-full p-2 border rounded" placeholder="Movie Name"
             value="<?= htmlspecialchars($data['m_name'] ?? '') ?>" required>

      <input name="m_rating" class="w-full p-2 border rounded" placeholder="Rating (ex: 8.5)"
             value="<?= htmlspecialchars($data['m_rating'] ?? '') ?>" required
             title="Masukkan angka maksimal dua digit, contoh: 8 atau 8.9">

      <input name="m_directed" class="w-full p-2 border rounded" placeholder="Directed By"
             value="<?= htmlspecialchars($data['m_directed'] ?? '') ?>" required>

      <select name="m_genre" class="w-full p-2 border rounded" required>
        <?php
        $genres = ['animation','action','horror','comedy','mystery','live action','series'];
        foreach ($genres as $g) {
          $sel = ($data && $data['m_genre'] == $g) ? 'selected' : '';
          echo "<option value=\"" . htmlspecialchars($g) . "\" $sel>" . htmlspecialchars($g) . "</option>";
        }
        ?>
      </select>

      <textarea name="m_desc" class="w-full p-2 border rounded" placeholder="Description" required><?= htmlspecialchars($data['m_desc'] ?? '') ?></textarea>

      <input type="file" name="m_image" accept="image/*" class="w-full" <?= $edit ? '' : 'required' ?>>
      <?php if ($data && !empty($data['m_image'])): ?>
        <img src="<?= htmlspecialchars($data['m_image']) ?>" class="w-32 mt-2 rounded border">
      <?php endif; ?>

      <div class="flex justify-end gap-3 pt-4">
        <a href="admin_dashboard.php" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</a>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
          <?= $edit ? "Update" : "Create" ?>
        </button>
      </div>
    </form>
  </div>
</body>
</html>
