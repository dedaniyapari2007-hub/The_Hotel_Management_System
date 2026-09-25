<?php
session_start();
include 'connection.php';

// Handle form submission FIRST (before any HTML is printed)
if (isset($_POST['submit'])) {
    $fname            = trim($_POST['fname']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Step 1: Basic validation
    if ($password !== $confirm_password) {
        header("Location: register.php?status=error&msg=" . urlencode("Passwords do not match."));
        exit;
    }

    if (strlen($password) < 6) {
        header("Location: register.php?status=error&msg=" . urlencode("Password must be at least 6 characters."));
        exit;
    }

    // Step 2: Make sure this name/email isn't already registered
    // (fname and email are both UNIQUE on the registation table)
    $checkSql  = "SELECT id FROM registation WHERE fname = ? OR email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $fname, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult && $checkResult->num_rows > 0) {
        $checkStmt->close();
        $conn->close();
        header("Location: register.php?status=error&msg=" . urlencode("That name or email is already registered."));
        exit;
    }
    $checkStmt->close();

    // Step 3: Hash the password and insert
    // NOTE on schema: `registation.conform_pass` is NOT NULL, but we never
    // store a raw/plaintext password anywhere. We store the same bcrypt
    // hash in both password_hash and conform_pass so the column constraint
    // is satisfied without keeping the plaintext confirm-password around.
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $conform_pass  = $password_hash;

    $insertSql  = "INSERT INTO registation (fname, email, password_hash, conform_pass) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("ssss", $fname, $email, $password_hash, $conform_pass);

    if ($insertStmt->execute()) {
        $insertStmt->close();
        $conn->close();

        // Step 4: Send them to login.php with a success message
        header("Location: login.php?status=success&msg=" . urlencode("Registration successful! Please log in."));
        exit;
    } else {
        $errMsg = $insertStmt->error;
        $insertStmt->close();
        $conn->close();
        header("Location: register.php?status=error&msg=" . urlencode("Registration failed: " . $errMsg));
        exit;
    }
}

// Build the message to display (from the redirect above)
$message = '';
if (isset($_GET['status']) && $_GET['status'] === 'error') {
    $message = isset($_GET['msg']) ? $_GET['msg'] : 'Something went wrong. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cormorant+Garamond:wght@400;500;600&family=Lilita+One&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="head_log">Sign Up</div>

    <div id="animation">
    <script
      src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.4/dist/dotlottie-wc.js"
      type="module"
    ></script>

    <dotlottie-wc
      src="https://lottie.host/a7315ae3-f965-4ea4-83be-b764c7b5b03d/MOnoZfM7ix.json"
      style="width: 300px;height: 300px"
      autoplay
      loop
    ></dotlottie-wc>
    </div>

    <?php if ($message !== ''): ?>
        <p class="status-message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form id="register-form" method="POST">
    <div class="field">
      <label>Full Name<span class="required">(Required)</span></label>
      <div class="name-row">
        <input type="text" name="fname" placeholder="John Doe" required>
      </div>
    </div>

    <div class="field">
      <label>Email<span class="required">(Required)</span></label>
      <div class="name-row">
        <input type="text" name="email" placeholder="abc@gmail.com" required>
      </div>
    </div>

    <div class="field">
      <label>Password <span class="required">(Required)</span></label>
      <input type="password" name="password" required>
    </div>

    <div class="field">
      <label>Confirm Password <span class="required">(Required)</span></label>
      <input type="password" name="confirm_password" required>
    </div>

    <button type="submit" class="submit-btn" name="submit">Sign Up</button>
    <div class="redirection">
    <label>Already Have An Account? <a href="login.php">Log In Here</a></label>
    </div>

    </form>
</body>
</html>