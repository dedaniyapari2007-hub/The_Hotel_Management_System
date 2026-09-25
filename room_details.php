<?php
include 'connection.php';
$room_id = isset($_GET['room_id']) ? (int) $_GET['room_id'] : 0;
$room = null;

if ($room_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
    $stmt->close();
}

if (!$room) {
    header("Location: our_rooms.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($room['room_name']); ?> - Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #F5EBE0;
        }
        .room-details-container {
            max-width: 1200px;
            margin: 60px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            gap: 50px;
        }
        .room-image-large {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
        }
        .room-image-large img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }
        .room-info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .room-info-section h1 {
            font-size: 40px;
            color: #1f2937;
            margin-bottom: 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 2px;
        }
        .room-info-section .price {
            font-size: 30px;
            color: #D4A373;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .room-info-section .description {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: justify;
        }
        .features {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            color: #333;
            background: #F5EBE0;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-book-now {
            display: inline-block;
            background: #1f2937;
            color: white;
            text-align: center;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
            align-self: flex-start;
        }
        .btn-book-now:hover {
            background: #D4A373;
            transform: translateY(-3px);
            color: white;
        }
        @media(max-width: 900px) {
            .room-details-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="room-details-container animate-on-scroll">
        <div class="room-image-large">
            <?php 
                $img_src = !empty($room['image_path']) ? htmlspecialchars($room['image_path']) : 'assets/images/room_1.jpg';
            ?>
            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>">
        </div>
        <div class="room-info-section">
            <h1><?php echo htmlspecialchars($room['room_name']); ?></h1>
            <div class="price">₹<?php echo number_format($room['price_per_night'], 0); ?> / night</div>
            <p class="description">
                <?php echo nl2br(htmlspecialchars($room['description'])); ?>
            </p>
            <div class="features">
                <div class="feature-item">
                    <i class="fa-solid fa-users"></i>
                    Max Occupancy: <?php echo htmlspecialchars($room['max_occupancy']); ?>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-bed"></i>
                    <?php echo htmlspecialchars($room['room_type']); ?>
                </div>
            </div>
            
            <a href="book_room.php?room_id=<?php echo $room_id; ?>" class="btn-book-now">Book This Room</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
