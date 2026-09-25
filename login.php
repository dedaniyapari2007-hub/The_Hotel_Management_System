<?php
session_start();
include 'connection.php';

// Handle form submission FIRST (before any HTML is printed)
if (isset($_POST['submit'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Step 1: Only allow login if this email/password matches a REGISTERED account
    $sql = "SELECT id, fname, password_hash FROM registation WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $account = $result->fetch_assoc();
        $stmt->close();

        if (password_verify($password, $account['password_hash'])) {
            // Step 2: Credentials are correct — record this login in the users table.
            // We use ON DUPLICATE KEY UPDATE so logging in again just refreshes
            // the row instead of throwing a duplicate-email error.
            $insertSql = "INSERT INTO users (email, password)
                          VALUES (?, ?)
                          ON DUPLICATE KEY UPDATE email = VALUES(email), password = VALUES(password)";
            $insertStmt = $conn->prepare($insertSql);
            // Re-store the same hash (never store the raw password)
            $insertStmt->bind_param("ss", $email, $account['password_hash']);

            try {
                $insertStmt->execute();
                $insertStmt->close();

                // Step 3: Start the session and go to the home page
                $_SESSION['user_id'] = $account['id'];
                $_SESSION['name']    = $account['fname'];
                $_SESSION['email']   = $email;

                $conn->close();
                header("Location: index.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $insertStmt->close();
                $conn->close();
                header("Location: register.php?status=error&msg=" . urlencode("Login failed: " . $e->getMessage()));
                exit;
            }
        } else {
            $conn->close();
            header("Location: register.php?status=error&msg=" . urlencode("Your password is incorrect."));
            exit;
        }
    } else {
        // No account with that email exists in registation — reject login
        $stmt->close();
        $conn->close();
        header("Location: register.php?status=error&msg=" . urlencode("No account found with that email. Please register first."));
        exit;
    }
}

// Build the message to display (from the redirect above)
$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = isset($_GET['msg']) ? $_GET['msg'] : 'You are logged in!';
    } elseif ($_GET['status'] === 'error') {
        $message = isset($_GET['msg']) ? $_GET['msg'] : 'Something went wrong. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
             <link rel="stylesheet" href="login.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="head_log">LogIn</div>
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

    <form id="login-form" method="POST">
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

    <button type="submit" class="submit-btn" name="submit">Login</button>
    <div class="redirection">
    <label>Don't Have An Account?  <a href="login.php">  Register Here</a></label>
    </div>

    </form>
</body>
</html>