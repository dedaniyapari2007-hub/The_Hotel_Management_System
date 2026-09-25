<?php
include '../db.php';
include 'includes/admin_auth_check.php';

// Only super_admin can manage admins
if ($_SESSION['admin_role'] !== 'super_admin') {
    die("Unauthorized access.");
}

// Handle delete
if (isset($_POST['delete_admin_id'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $del_id = (int) $_POST['delete_admin_id'];
    // prevent deleting oneself
    if ($del_id !== $_SESSION['admin_id']) {
        $conn->query("DELETE FROM admins WHERE admin_id=$del_id");
    }
    header("Location: manage_admins.php");
    exit;
}

// Handle add
if (isset($_POST['add_admin'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO admins (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hash, $role);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_admins.php");
    exit;
}

include 'includes/admin_header.php';
$admins = $conn->query("SELECT admin_id, full_name, email, role, created_at FROM admins ORDER BY created_at ASC");
?>

<h1>Manage Admins</h1>

<div class="card" style="max-width: 600px; margin-bottom: 30px;">
    <h2>Add New Admin</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>
        </div>
        <button type="submit" name="add_admin" class="btn">Add Admin</button>
    </form>
</div>

<div class="card" style="overflow-x: auto;">
    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
            <th>Action</th>
        </tr>
        <?php while($a = $admins->fetch_assoc()): ?>
        <tr>
            <td><?= $a['admin_id'] ?></td>
            <td><?= htmlspecialchars($a['full_name']) ?></td>
            <td><?= htmlspecialchars($a['email']) ?></td>
            <td><?= htmlspecialchars($a['role']) ?></td>
            <td><?= $a['created_at'] ?></td>
            <td>
                <?php if ($a['admin_id'] !== $_SESSION['admin_id']): ?>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this admin?');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="delete_admin_id" value="<?= $a['admin_id'] ?>">
                    <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Delete</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'includes/admin_footer.php'; ?>
