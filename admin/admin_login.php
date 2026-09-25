
<?php
// db.php — shared database connection
// Default XAMPP settings: user "root", no password.
// If your MySQL has a password, set it below.

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "Hotel_management";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?><?php
session_start();
include '../db.php'; // Use db.php as requested

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT admin_id, full_name, password_hash, role FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        if (password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_role'] = $admin['role'];

            $stmt->close();
            $conn->close();
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No admin account found with that email.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Platinum Palace</title>
    <link rel="stylesheet" href="../login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body style="background-color: #F5EBE0;">
    <div class="head_log">Admin LogIn</div>
    <div id="animation">
        <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.4/dist/dotlottie-wc.js" type="module"></script>
        <dotlottie-wc src="https://lottie.host/a7315ae3-f965-4ea4-83be-b764c7b5b03d/MOnoZfM7ix.json" style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
    </div>

    <?php if (isset($error)): ?>
        <p class="status-message" style="text-align: center; color: #b00020; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form id="login-form" method="POST" action="admin_login.php">
        <div class="field">
            <label>Email<span class="required">(Required)</span></label>
            <div class="name-row">
                <input type="email" name="email" placeholder="admin@platinumpalace.com" required>
            </div>
        </div>
        <div class="field">
            <label>Password <span class="required">(Required)</span></label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="submit-btn" name="submit">Login to Admin Panel</button>
        <div class="redirection">
            <label><a href="../index.php">&larr; Back to Main Site</a></label>
        </div>
    </form>
</body>
</html>
