<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platinum Palace - Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="admin-sidebar">
    <div class="logo">
        <i class="fa-solid fa-crown" style="color: var(--primary-accent);"></i><br>
        Platinum<br>Palace
    </div>
    <ul>
        <li><a href="dashboard.php"><i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a></li>
        <li><a href="manage_rooms.php"><i class="fa-solid fa-bed"></i> <span>Rooms</span></a></li>
        <li><a href="manage_bookings.php"><i class="fa-solid fa-calendar-check"></i> <span>Bookings</span></a></li>
        <li><a href="manage_guests.php"><i class="fa-solid fa-users"></i> <span>Guests</span></a></li>
        <li><a href="manage_messages.php"><i class="fa-solid fa-envelope"></i> <span>Messages</span></a></li>
        <li><a href="manage_reviews.php"><i class="fa-solid fa-star"></i> <span>Reviews</span></a></li>
        <li><a href="manage_venues.php"><i class="fa-solid fa-utensils"></i> <span>Venues</span></a></li>
        <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'super_admin'): ?>
            <li><a href="manage_admins.php"><i class="fa-solid fa-user-shield"></i> <span>Admins</span></a></li>
        <?php endif; ?>
        <li><a href="admin_logout.php"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a></li>
    </ul>
</div>

<div class="admin-main">
    <div class="admin-topbar">
        <div class="admin-info">
            Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> (<?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $_SESSION['admin_role']))); ?>)
        </div>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="admin-content">
