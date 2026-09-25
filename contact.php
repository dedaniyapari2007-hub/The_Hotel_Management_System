<?php
include 'connection.php';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName  = $_POST['lastName'];
    $email     = $_POST['email'];
    $message   = $_POST['message'];

    $sql = "INSERT INTO contact_messages (first_name, last_name, email, message) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $message);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: contact.php?status=success");
        exit;
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: contact.php?status=error&msg=" . urlencode("Failed to send message: " . $error));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
     <link rel="stylesheet" href="contact.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include'navbar.php'?>
  <div class="contact_head">
    <h1>Do You Have Any Questions?</h1>
    <h2>Contact Us <i class="fa-solid fa-face-grin-wide fa-fade" style="color: rgb(255, 212, 59);"></i> </h2>
  </div>
  <form id="contactForm" method="POST">
    <div class="field">
      <label>Name <span class="required">(Required)</span></label>
      <div class="name-row">
        <input type="text" name="firstName" placeholder="First name" required>
        <input type="text" name="lastName" placeholder="Last name" required>
      </div>
    </div>

    <div class="field">
      <label>E-mail <span class="required">(Required)</span></label>
      <input type="email" name="email" required>
    </div>

    <div class="field">
      <label>Ask us anything <span class="required">(Required)</span></label>
      <textarea name="message" required></textarea>
    </div>

    <button type="submit" class="submit-btn" name="submit">Submit</button>
  </form>

  <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
  <script>
    alert('Your message was sent successfully! We will get back to you soon.');
  </script>
  
<?php endif; ?>
<?php include'footer.php'?>
</body>
</html>