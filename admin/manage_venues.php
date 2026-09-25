<?php
include '../db.php';
include 'includes/admin_auth_check.php';

// Handle delete
if (isset($_POST['delete_venue_id'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $del_id = (int) $_POST['delete_venue_id'];
    $conn->query("DELETE FROM venues WHERE venue_id=$del_id");
    header("Location: manage_venues.php");
    exit;
}

// Handle add/edit
if (isset($_POST['save_venue'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $venue_id = (int) $_POST['venue_id'];
    $venue_name = $_POST['venue_name'];
    $description = $_POST['description'];
    $opening_hours = $_POST['opening_hours'];
    $display_order = (int) $_POST['display_order'];
    $logo_path = $_POST['logo_path_existing'];
    $image_path = $_POST['image_path_existing'];

    // Handle file upload for logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['logo']['tmp_name'];
        $name = basename($_FILES['logo']['name']);
        $target = "../assets/images/" . time() . "_logo_" . $name;
        if (move_uploaded_file($tmp, $target)) {
            $logo_path = "assets/images/" . time() . "_logo_" . $name;
        }
    }
    
    // Handle file upload for image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $target = "../assets/images/" . time() . "_img_" . $name;
        if (move_uploaded_file($tmp, $target)) {
            $image_path = "assets/images/" . time() . "_img_" . $name;
        }
    }

    if ($venue_id > 0) {
        $stmt = $conn->prepare("UPDATE venues SET venue_name=?, description=?, opening_hours=?, logo_path=?, image_path=?, display_order=? WHERE venue_id=?");
        $stmt->bind_param("sssssii", $venue_name, $description, $opening_hours, $logo_path, $image_path, $display_order, $venue_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO venues (venue_name, description, opening_hours, logo_path, image_path, display_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $venue_name, $description, $opening_hours, $logo_path, $image_path, $display_order);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: manage_venues.php");
    exit;
}

include 'includes/admin_header.php';
$venues = $conn->query("SELECT * FROM venues ORDER BY display_order ASC, venue_id ASC");
?>

<h1>Manage Venues</h1>

<div class="card">
    <h2>Venues List</h2>
    <button class="btn" onclick="document.getElementById('venueForm').scrollIntoView(); clearForm();">Add New Venue</button>
    <br><br>
    <table class="admin-table">
        <tr>
            <th>Order</th>
            <th>Name</th>
            <th>Hours</th>
            <th>Actions</th>
        </tr>
        <?php while($v = $venues->fetch_assoc()): ?>
        <tr>
            <td><?= $v['display_order'] ?></td>
            <td><?= htmlspecialchars($v['venue_name']) ?></td>
            <td><?= nl2br(htmlspecialchars($v['opening_hours'])) ?></td>
            <td>
                <button class="btn" onclick="editVenue(<?= htmlspecialchars(json_encode($v)) ?>)">Edit</button>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this venue?');">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="delete_venue_id" value="<?= $v['venue_id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="card" id="venueForm" style="max-width: 600px;">
    <h2 id="formTitle">Add Venue</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="venue_id" id="f_venue_id" value="0">
        <input type="hidden" name="logo_path_existing" id="f_logo_path_existing" value="">
        <input type="hidden" name="image_path_existing" id="f_image_path_existing" value="">

        <div class="form-group">
            <label>Venue Name</label>
            <input type="text" name="venue_name" id="f_venue_name" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="f_description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label>Opening Hours</label>
            <textarea name="opening_hours" id="f_opening_hours" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="display_order" id="f_display_order" value="0">
        </div>
        <div class="form-group">
            <label>Logo Upload</label>
            <input type="file" name="logo" accept="image/*">
            <small id="currentLogo"></small>
        </div>
        <div class="form-group">
            <label>Main Image Upload</label>
            <input type="file" name="image" accept="image/*">
            <small id="currentImage"></small>
        </div>
        <button type="submit" name="save_venue" class="btn">Save Venue</button>
        <button type="button" class="btn" style="background:#aaa;" onclick="clearForm()">Cancel</button>
    </form>
</div>

<script>
function editVenue(venue) {
    document.getElementById('formTitle').innerText = "Edit Venue";
    document.getElementById('f_venue_id').value = venue.venue_id;
    document.getElementById('f_venue_name').value = venue.venue_name;
    document.getElementById('f_description').value = venue.description;
    document.getElementById('f_opening_hours').value = venue.opening_hours;
    document.getElementById('f_display_order').value = venue.display_order;
    document.getElementById('f_logo_path_existing').value = venue.logo_path;
    document.getElementById('f_image_path_existing').value = venue.image_path;
    document.getElementById('currentLogo').innerText = venue.logo_path ? "Current Logo: " + venue.logo_path : "";
    document.getElementById('currentImage').innerText = venue.image_path ? "Current Image: " + venue.image_path : "";
    document.getElementById('venueForm').scrollIntoView();
}
function clearForm() {
    document.getElementById('formTitle').innerText = "Add Venue";
    document.getElementById('f_venue_id').value = "0";
    document.getElementById('f_venue_name').value = "";
    document.getElementById('f_description').value = "";
    document.getElementById('f_opening_hours').value = "";
    document.getElementById('f_display_order').value = "0";
    document.getElementById('f_logo_path_existing').value = "";
    document.getElementById('f_image_path_existing').value = "";
    document.getElementById('currentLogo').innerText = "";
    document.getElementById('currentImage').innerText = "";
}
</script>

<?php include 'includes/admin_footer.php'; ?>
