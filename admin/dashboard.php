<?php
include '../db.php';
include 'includes/admin_auth_check.php';
include 'includes/admin_header.php';

// Total bookings
$res = $conn->query("SELECT COUNT(*) as c FROM bookings");
$total_bookings = $res->fetch_assoc()['c'];

// Today's Check-ins
$res = $conn->query("SELECT COUNT(*) as c FROM bookings WHERE check_in_date = CURDATE() AND status = 'confirmed'");
$today_checkins = $res->fetch_assoc()['c'];

// Today's Check-outs
$res = $conn->query("SELECT COUNT(*) as c FROM bookings WHERE check_out_date = CURDATE() AND status IN ('checked_in', 'confirmed')");
$today_checkouts = $res->fetch_assoc()['c'];

// Revenue this month
$res = $conn->query("SELECT SUM(total_amount) as s FROM bookings WHERE MONTH(check_in_date) = MONTH(CURDATE()) AND YEAR(check_in_date) = YEAR(CURDATE()) AND status != 'cancelled'");
$revenue_month = $res->fetch_assoc()['s'] ?? 0;

// Unread messages
$res = $conn->query("SELECT COUNT(*) as c FROM contact_messages WHERE is_read = FALSE");
$unread_messages = $res->fetch_assoc()['c'];

// Occupancy %
$res = $conn->query("SELECT COUNT(*) as total, SUM(IF(status='occupied', 1, 0)) as occupied FROM rooms");
$room_stats = $res->fetch_assoc();
$occupancy = $room_stats['total'] > 0 ? round(($room_stats['occupied'] / $room_stats['total']) * 100) : 0;
?>

<h1>Dashboard</h1>
<div class="dashboard-cards">
    <div class="stat-card">
        <h3>Total Bookings</h3>
        <div class="stat-value"><?php echo $total_bookings; ?></div>
    </div>
    <div class="stat-card">
        <h3>Today's Check-ins</h3>
        <div class="stat-value"><?php echo $today_checkins; ?></div>
    </div>
    <div class="stat-card">
        <h3>Today's Check-outs</h3>
        <div class="stat-value"><?php echo $today_checkouts; ?></div>
    </div>
    <div class="stat-card">
        <h3>Revenue This Month</h3>
        <div class="stat-value">₹<?php echo number_format($revenue_month); ?></div>
    </div>
    <div class="stat-card">
        <h3>Unread Messages</h3>
        <div class="stat-value"><?php echo $unread_messages; ?></div>
    </div>
    <div class="stat-card">
        <h3>Occupancy Rate</h3>
        <div class="stat-value"><?php echo $occupancy; ?>%</div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
