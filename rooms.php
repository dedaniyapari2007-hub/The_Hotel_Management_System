<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rooms</title>
    <link rel="stylesheet" href="rooms.css?v=2">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="links_of_rooms">
        <div class="dynamic_rooms_container">
            <?php
            include_once 'connection.php';
            $query = "SELECT * FROM rooms";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $roomId = $row['room_id'];
                    $roomName = htmlspecialchars($row['room_name']);
                    $imagePath = !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'assets/images/room_1.jpg';
                    ?>
                    <div class="room_card">
                        <h2><?php echo $roomName; ?></h2>
                        <a href="room_details.php?room_id=<?php echo $roomId; ?>">
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo $roomName; ?>">
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='text-align:center; padding: 50px; font-size: 20px;'>No rooms available currently.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>