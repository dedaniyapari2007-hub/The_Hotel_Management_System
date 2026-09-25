<?php
include '../db.php';
include 'includes/admin_auth_check.php';

// Handle delete
if (isset($_POST['delete_room_id'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $del_id = (int) $_POST['delete_room_id'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $del_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_rooms.php");
    exit;
}

// Handle add/edit
if (isset($_POST['save_room'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $room_id = (int) $_POST['room_id'];
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $price = (float) $_POST['price_per_night'];
    $max_occupancy = (int) $_POST['max_occupancy'];
    $status = $_POST['status'];
    $image_path = $_POST['image_path_existing'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $target = "../assets/images/" . time() . "_" . $name;
        if (move_uploaded_file($tmp, $target)) {
            $image_path = "assets/images/" . time() . "_" . $name;
        }
    }

    if ($room_id > 0) {
        $stmt = $conn->prepare("UPDATE rooms SET room_name=?, room_type=?, description=?, price_per_night=?, max_occupancy=?, image_path=?, status=? WHERE room_id=?");
        $stmt->bind_param("sssdissi", $room_name, $room_type, $description, $price, $max_occupancy, $image_path, $status, $room_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, room_type, description, price_per_night, max_occupancy, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiss", $room_name, $room_type, $description, $price, $max_occupancy, $image_path, $status);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: manage_rooms.php");
    exit;
}

include 'includes/admin_header.php';
$rooms = $conn->query("SELECT * FROM rooms ORDER BY room_id DESC");
?>

<h1>Manage Rooms</h1>

<div class="card">
    <h2>Rooms List</h2>
    <button class="btn" onclick="document.getElementById('roomForm').scrollIntoView(); clearForm();">Add New Room</button>
    <br><br>
    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($r = $rooms->fetch_assoc()): ?>
        <tr>
            <td><?= $r['room_id'] ?></td>
            <td><?= htmlspecialchars($r['room_name']) ?></td>
            <td><?= htmlspecialchars($r['room_type']) ?></td>
            <td>₹<?= number_format($r['price_per_night']) ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td>
                <button class="btn" onclick="editRoom(<?= htmlspecialchars(json_encode($r)) ?>)">Edit</button>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this room?');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="delete_room_id" value="<?= $r['room_id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="card" id="roomForm" style="max-width: 600px;">
    <h2 id="formTitle">Add Room</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="room_id" id="f_room_id" value="0">
        <input type="hidden" name="image_path_existing" id="f_image_path_existing" value="">

        <div class="form-group">
            <label>Room Name</label>
            <input type="text" name="room_name" id="f_room_name" required>
        </div>
        <div class="form-group">
            <label>Room Type</label>
            <input type="text" name="room_type" id="f_room_type">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="f_description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label>Price Per Night</label>
            <input type="number" step="0.01" name="price_per_night" id="f_price" required>
        </div>
        <div class="form-group">
            <label>Max Occupancy</label>
            <input type="number" name="max_occupancy" id="f_max_occupancy" value="2" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" id="f_status">
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
        <div class="form-group">
            <label>Image Upload</label>
            <input type="file" name="image" accept="image/*">
            <small id="currentImage"></small>
        </div>
        <button type="submit" name="save_room" class="btn">Save Room</button>
        <button type="button" class="btn" style="background:#aaa;" onclick="clearForm()">Cancel</button>
    </form>
</div>

<script>
function editRoom(room) {
    document.getElementById('formTitle').innerText = "Edit Room";
    document.getElementById('f_room_id').value = room.room_id;
    document.getElementById('f_room_name').value = room.room_name;
    document.getElementById('f_room_type').value = room.room_type;
    document.getElementById('f_description').value = room.description;
    document.getElementById('f_price').value = room.price_per_night;
    document.getElementById('f_max_occupancy').value = room.max_occupancy;
    document.getElementById('f_status').value = room.status;
    document.getElementById('f_image_path_existing').value = room.image_path;
    document.getElementById('currentImage').innerText = room.image_path ? "Current: " + room.image_path : "";
    document.getElementById('roomForm').scrollIntoView();
}
function clearForm() {
    document.getElementById('formTitle').innerText = "Add Room";
    document.getElementById('f_room_id').value = "0";
    document.getElementById('f_room_name').value = "";
    document.getElementById('f_room_type').value = "";
    document.getElementById('f_description').value = "";
    document.getElementById('f_price').value = "";
    document.getElementById('f_max_occupancy').value = "2";
    document.getElementById('f_status').value = "available";
    document.getElementById('f_image_path_existing').value = "";
    document.getElementById('currentImage').innerText = "";
}
</script>

<?php include 'includes/admin_footer.php'; ?>
