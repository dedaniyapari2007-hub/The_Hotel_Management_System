<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $reviewer_name = trim($_POST['reviewer_name']);
    $title = trim($_POST['title']);
    $review_text = trim($_POST['review_text']);
    $rating = (int) $_POST['rating'];

    // Basic validation
    if (empty($reviewer_name) || empty($title) || empty($review_text) || $rating < 1 || $rating > 5) {
        // Redirect back with an error
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $sql = "INSERT INTO reviews (reviewer_name, title, review_text, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $reviewer_name, $title, $review_text, $rating);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    // Redirect back
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
