<?php
include '../db.php';
include 'includes/admin_auth_check.php';

// Handle delete
if (isset($_POST['delete_review_id'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $del_id = (int) $_POST['delete_review_id'];
    $conn->query("DELETE FROM reviews WHERE review_id=$del_id");
    header("Location: manage_reviews.php");
    exit;
}

// Handle add
if (isset($_POST['add_review'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $name = $_POST['reviewer_name'];
    $title = $_POST['title'];
    $text = $_POST['review_text'];
    $rating = (int) $_POST['rating'];
    $stmt = $conn->prepare("INSERT INTO reviews (reviewer_name, title, review_text, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $title, $text, $rating);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_reviews.php");
    exit;
}

include 'includes/admin_header.php';
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<h1>Manage Reviews</h1>
<div class="card" style="max-width: 600px; margin-bottom: 30px;">
    <h2>Add New Review</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="form-group">
            <label>Reviewer Name</label>
            <input type="text" name="reviewer_name" required>
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>Review Text</label>
            <textarea name="review_text" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label>Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" value="5" required>
        </div>
        <button type="submit" name="add_review" class="btn">Add Review</button>
    </form>
</div>

<div class="card" style="overflow-x: auto;">
    <table class="admin-table">
        <tr>
            <th>Date</th>
            <th>Reviewer</th>
            <th>Title</th>
            <th>Text</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        <?php while($r = $reviews->fetch_assoc()): ?>
        <tr>
            <td><?= $r['created_at'] ?></td>
            <td><?= htmlspecialchars($r['reviewer_name']) ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td style="max-width: 300px; word-wrap: break-word;"><?= htmlspecialchars($r['review_text']) ?></td>
            <td><?= $r['rating'] ?>/5</td>
            <td>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this review?');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="delete_review_id" value="<?= $r['review_id'] ?>">
                    <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'includes/admin_footer.php'; ?>
