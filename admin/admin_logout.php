<?php
session_start();
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_role']);
header("Location: admin_login.php");
exit;
?>
