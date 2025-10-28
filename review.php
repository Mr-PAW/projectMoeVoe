<?php
include 'db_connect.php';
session_start();

// Inline edit handler (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
  header('Content-Type: application/json; charset=utf-8');

  if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
    exit;
  }

  $r_id = isset($_POST['r_id']) ? (int)$_POST['r_id'] : 0;
  $new_review = isset($_POST['review']) ? trim($_POST['review']) : '';

  if ($r_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid review id.']);
    exit;
  }

  if (strlen($new_review) === 0) {
    echo json_encode(['success' => false, 'message' => 'Review cannot be empty.']);
    exit;
  }

  if (strlen($new_review) > 2000) {
    echo json_encode(['success' => false, 'message' => 'Review too long.']);
    exit;
  }

  // Ensure the review belongs to the logged-in user
  $check = $conn->prepare("SELECT user_id, m_id FROM reviews WHERE r_id = ?");
  $check->bind_param("i", $r_id);
  $check->execute();
  $res = $check->get_result();
  if ($res->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Review not found.']);
    exit;
  }
  $row = $res->fetch_assoc();
  if ((int)$row['user_id'] !== (int)$_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
  }

  $stmt = $conn->prepare("UPDATE reviews SET review = ? WHERE r_id = ? AND user_id = ?");
  $stmt->bind_param("sii", $new_review, $r_id, $_SESSION['user_id']);
  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Review updated.', 'review' => $new_review]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
  }
  exit;
}

if (!isset($_GET['id'])) {
  die("Movie ID tidak ditemukan!");
}
$m_id = (int)$_GET['id'];

// Query ambil detail movie
$stmt = $conn->prepare("SELECT * FROM movie WHERE m_id = ?");
$stmt->bind_param("i", $m_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  die("Film tidak ditemukan!");
}
$movie = $result->fetch_assoc();

// Ambil semua review
$rev_stmt = $conn->prepare("
  SELECT r.r_id, r.review, a.name, a.id AS user_id
  FROM reviews r
  JOIN account a ON r.user_id = a.id
  WHERE r.m_id = ?
  ORDER BY r.r_id DESC
");
$rev_stmt->bind_param("i", $m_id);
$rev_stmt->execute();
$reviews = $rev_stmt->get_result();

// Cek apakah user login sudah pernah review film ini
$user_review = null;
if (isset($_SESSION['user_id'])) {
  $check_stmt = $conn->prepare("SELECT * FROM reviews WHERE m_id = ? AND user_id = ?");
  $check_stmt->bind_param("ii", $m_id, $_SESSION['user_id']);
  $check_stmt->execute();
  $user_review = $check_stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($movie['m_name']) ?> - Review</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <?php include 'header.php'; ?>

  <!-- DETAIL MOVIE -->
  <div class="max-w-[1500px] mx-auto mt-10 p-6 bg-white shadow-xl rounded-xl flex flex-col md:flex-row gap-8">
    <!-- KIRI -->
    <div class="flex-1">
      <h1 class="text-4xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($movie['m_name']) ?></h1>
      <div class="flex items-center space-x-2 mb-3">
        <span class="text-yellow-500 text-lg font-semibold">⭐ <?= htmlspecialchars($movie['m_rating']) ?>/10</span>
      </div>
      <p class="italic text-gray-600 mb-4"><?= htmlspecialchars($movie['m_genre']) ?></p>
      <div class="inline-block bg-purple-700 text-white px-3 py-1 rounded-lg mb-5">
        Directed by: <?= htmlspecialchars($movie['m_directed']) ?>
      </div>
      <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Synopsis</h2>
        <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($movie['m_desc'])) ?></p>
      </div>
    </div>

    <!-- KANAN: POSTER -->
    <div class="md:w-1/2 flex justify-center">
      <div class="w-3/4 sm:w-2/3 md:w-3/4 lg:w-2/3 xl:w-1/2 aspect-[3/4] overflow-hidden rounded-xl shadow-lg border border-gray-300 bg-gray-200">
        <img 
          src="<?= htmlspecialchars($movie['m_image']) ?>" 
          alt="<?= htmlspecialchars($movie['m_name']) ?>"
          class="w-full h-full object-cover object-center"
        >
      </div>
    </div>
  </div>

  <!-- BAGIAN REVIEW -->
  <div class="max-w-[1600px] mx-auto mt-10 bg-white p-6 rounded-xl shadow-md mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">User Reviews</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
      <?php if ($user_review): ?>
        <!-- REVIEW USER SENDIRI (inline edit) -->
        <!-- REVIEW USER SENDIRI (inline edit) -->
        <div class="mb-6 bg-blue-50 border border-blue-300 p-5 rounded-lg shadow-sm" id="user-review-block">
        <div class="flex justify-between items-start flex-wrap gap-4">

            <!-- KIRI: Nama + Review -->
            <div class="flex-1">
            <p class="font-semibold text-blue-800 mb-1">
                <?= htmlspecialchars($_SESSION['user_name']) ?> 
                <span class="text-gray-500">(Your Review)</span>
            </p>

            <!-- Tampilan review -->
            <div id="user-review-display">
                <p class="text-gray-800 whitespace-pre-line" id="user-review-text">
                <?= nl2br(htmlspecialchars($user_review['review'])) ?>
                </p>
            </div>

            <!-- FORM EDIT (Hidden awalnya) -->
            <form id="user-edit-form" class="hidden mt-3" onsubmit="return submitEdit(event);">
                <input type="hidden" name="r_id" id="edit-r-id" value="<?= (int)$user_review['r_id'] ?>">

                <textarea
                name="review"
                id="edit-review-text"
                maxlength="2000"
                required
                placeholder="Write your review here (max 2000 characters)..."
                class="w-full min-h-[120px] sm:min-h-[150px] p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none mb-3"
                ><?= htmlspecialchars($user_review['review']) ?></textarea>

                <div class="flex items-center gap-3">
                <button 
                    type="submit"
                    class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition"
                >
                    Save
                </button>
                <button 
                    type="button" 
                    id="cancel-edit"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                >
                    Cancel
                </button>
                </div>
            </form>
            </div>

            <!-- KANAN: Tombol aksi -->
            <div class="flex gap-2 shrink-0">
            <button 
                id="show-edit-btn" 
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
            >
                Edit
            </button>

            <a 
                href="delete_review.php?r_id=<?= $user_review['r_id'] ?>&m_id=<?= $m_id ?>"
                onclick="return confirm('Are you sure you want to delete your review?')"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
            >
                Delete
            </a>
            </div>
        </div>
        </div>


        <script>
          const showEditBtn = document.getElementById('show-edit-btn');
          const editForm = document.getElementById('user-edit-form');
          const displayDiv = document.getElementById('user-review-display');
          const cancelBtn = document.getElementById('cancel-edit');
          const rIdInput = document.getElementById('edit-r-id');

          showEditBtn.addEventListener('click', () => {
            displayDiv.classList.add('hidden');
            editForm.classList.remove('hidden');
            document.getElementById('edit-review-text').focus();
          });

          cancelBtn.addEventListener('click', () => {
            editForm.classList.add('hidden');
            displayDiv.classList.remove('hidden');
          });

          function escapeHtml(str) {
            return str.replace(/[&<>"'\/]/g, function (s) {
              const entityMap = {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;'};
              return entityMap[s];
            });
          }

          async function submitEdit(e) {
            e.preventDefault();
            const r_id = rIdInput.value;
            const reviewText = document.getElementById('edit-review-text').value.trim();

            if (reviewText.length === 0) {
                alert('Review cannot be empty.');
                return false;
            }

            const formData = new FormData();
            formData.append('r_id', r_id);
            formData.append('review', reviewText);

            try {
                const resp = await fetch('edit_review.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
                });
                const data = await resp.json();
                if (data.success) {
                const textEl = document.getElementById('user-review-text');
                textEl.innerHTML = escapeHtml(data.review).replace(/\n/g, '<br>');
                editForm.classList.add('hidden');
                displayDiv.classList.remove('hidden');
                alert('Review updated successfully.');
                } else {
                alert(data.message || 'Update failed.');
                }
            } catch (err) {
                console.error(err);
                alert('Network error.');
            }
            return false;
            }

        </script>
      <?php else: ?>
        <!-- USER BELUM REVIEW -->
        <button 
          id="showFormBtn"
          class="mb-4 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
          Add Review
        </button>

        <form id="reviewForm" action="add_review.php" method="POST" class="hidden mb-6">
          <input type="hidden" name="m_id" value="<?= $m_id ?>">
          <textarea 
            name="review" 
            rows="3" 
            maxlength="2000"
            required
            placeholder="Write your review here (max 2000 characters)..."
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3"
          ></textarea>
          <button 
            type="submit"
            class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition"
          >
            Post Review
          </button>
        </form>

        <script>
          const btn = document.getElementById('showFormBtn');
          const form = document.getElementById('reviewForm');
          btn.addEventListener('click', () => form.classList.toggle('hidden'));
        </script>
      <?php endif; ?>
    <?php else: ?>
      <p class="text-gray-600 italic mb-6">
        You must <a href="login.php" class="text-blue-600 hover:underline">login</a> to write a review.
      </p>
    <?php endif; ?>

    <!-- REVIEW LAINNYA -->
    <?php if ($reviews->num_rows > 0): ?>
      <div class="space-y-4">
        <?php while ($rev = $reviews->fetch_assoc()): ?>
          <?php if (!isset($_SESSION['user_id']) || $rev['user_id'] != $_SESSION['user_id']): ?>
            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
              <p class="font-semibold text-purple-700 mb-1"><?= htmlspecialchars($rev['name']) ?></p>
              <p class="text-gray-800"><?= nl2br(htmlspecialchars($rev['review'])) ?></p>
            </div>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-500 italic">No reviews yet. Be the first to share your thoughts!</p>
    <?php endif; ?>
  </div>

</body>
</html>
