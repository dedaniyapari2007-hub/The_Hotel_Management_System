<?php
include '../db.php';
include 'includes/admin_auth_check.php';
include 'includes/admin_header.php';

$search = $_GET['search'] ?? '';

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM guests WHERE first_name LIKE CONCAT('%', ?, '%') OR last_name LIKE CONCAT('%', ?, '%') OR email LIKE CONCAT('%', ?, '%') ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $guests = $stmt->get_result();
    $stmt->close();
} else {
    $guests = $conn->query("SELECT * FROM guests ORDER BY created_at DESC LIMIT 100");
}
?>

<h1>Manage Guests</h1>
<div class="card" style="overflow-x: auto;">
    <form method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Search name or email..." value="<?= htmlspecialchars($search) ?>" style="padding: 10px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
        <button type="submit" class="btn">Search</button>
        <?php if ($search !== ''): ?>
            <a href="manage_guests.php" class="btn" style="background: #666;">Clear</a>
        <?php endif; ?>
    </form>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joined</th>
            <th>Total Bookings</th>
        </tr>
        <?php while($g = $guests->fetch_assoc()): 
            $res = $conn->query("SELECT COUNT(*) as c FROM bookings WHERE guest_id = " . (int)$g['guest_id']);
            $bcount = $res->fetch_assoc()['c'];
        ?>
        <tr>
            <td><?= $g['guest_id'] ?></td>
            <td><?= htmlspecialchars($g['first_name'] . ' ' . $g['last_name']) ?></td>
            <td><?= htmlspecialchars($g['email']) ?></td>
            <td><?= htmlspecialchars($g['phone']) ?></td>
            <td><?= $g['created_at'] ?></td>
            <td><?= $bcount ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'includes/admin_footer.php'; ?>
