<?php
include '../db.php';
include 'includes/admin_auth_check.php';

// Mark as read
if (isset($_POST['mark_read'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $id = (int) $_POST['message_id'];
    $conn->query("UPDATE contact_messages SET is_read=1 WHERE message_id=$id");
    header("Location: manage_messages.php");
    exit;
}

// Delete
if (isset($_POST['delete_msg'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $id = (int) $_POST['message_id'];
    $conn->query("DELETE FROM contact_messages WHERE message_id=$id");
    header("Location: manage_messages.php");
    exit;
}

include 'includes/admin_header.php';
$msgs = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>

<h1>Manage Messages</h1>
<div class="card" style="overflow-x: auto;">
    <table class="admin-table">
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($m = $msgs->fetch_assoc()): ?>
        <tr style="<?= $m['is_read'] ? 'color: #777;' : 'font-weight:bold;' ?>">
            <td><?= $m['submitted_at'] ?></td>
            <td><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($m['email']) ?>"><?= htmlspecialchars($m['email']) ?></a></td>
            <td style="max-width: 300px; word-wrap: break-word;"><?= nl2br(htmlspecialchars($m['message'])) ?></td>
            <td><?= $m['is_read'] ? 'Read' : 'Unread' ?></td>
            <td>
                <form method="POST" style="display:flex; gap: 5px;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="message_id" value="<?= $m['message_id'] ?>">
                    <?php if (!$m['is_read']): ?>
                        <button type="submit" name="mark_read" class="btn" style="padding: 4px 8px; font-size: 12px;">Mark Read</button>
                    <?php endif; ?>
                    <button type="submit" name="delete_msg" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;" onclick="return confirm('Delete this message?');">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'includes/admin_footer.php'; ?>
