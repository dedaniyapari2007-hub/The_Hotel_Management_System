<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food and Drink</title>
      <link rel="stylesheet" href="food_drink.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <?php include'navbar.php'?>
    <div class="main_body_of_food_&_drink">
      <div class="heading_part">
        <div id="line1">Food And Drink</div>
        <div id="line2">Enjoy The Heart Of The Platinum</div>
        <div id="line3"><p>"Breakfast, lunch and dinner
          We serve both continental breakfasts and modern asian cuisine."</p></div>
      </div>
      <div class="informaion_part">
        <?php
          // ------------------------------------------------------------------
          // 1) DEFAULT VENUES
          // These are always shown, even if there is no database or the
          // "venues" table is empty. Edit/remove entries here any time.
          // ------------------------------------------------------------------
          $default_venues = [
              [
                  'venue_id'      => 'default-1',
                  'display_order' => 1,
                  'logo_path'     => 'assets/images/food_drink/michelsen_logo.webp',
                  'image_path'    => 'assets/images/food_drink/michelsen_main.jpg',
                  'description'   => 'Michelsen serves a refined mix of continental breakfasts and modern Asian cuisine, crafted from the freshest local ingredients.',
                  'opening_hours' => "Breakfast: 7:00 AM – 10:30 AM\nLunch: 12:00 PM – 3:00 PM\nDinner: 6:00 PM – 10:30 PM",
              ],
              [
                  'venue_id'      => 'default-2',
                  'display_order' => 2,
                  'logo_path'     => 'assets/images/food_drink/porto13_logo.webp',
                  'image_path'    => 'assets/images/food_drink/porto13_main.jpg',
                  'description'   => 'Porto 13 Pizzeria & Bar fires up wood-oven pizzas topped with fresh mozzarella, pepperoni and basil, paired with a lively bar selection.',
                  'opening_hours' => "Daily: 12:00 PM – 11:00 PM",
              ],
              [
                  'venue_id'      => 'default-3',
                  'display_order' => 3,
                  'logo_path'     => 'assets/images/food_drink/tonga_logo.webp',
                  'image_path'    => 'assets/images/food_drink/tonga_main.jpg',
                  'description'   => 'Tonga Bar brings tropical-inspired cocktails and late-night vibes to the heart of the hotel, perfect for unwinding after dark.',
                  'opening_hours' => "Daily: 6:00 PM – 1:00 AM",
              ],
              [
                  'venue_id'      => 'default-4',
                  'display_order' => 4,
                  'logo_path'     => 'assets/images/food_drink/belgio_logo.webp',
                  'image_path'    => 'assets/images/food_drink/belgio_main.jpg',
                  'description'   => 'Belgio Gastro Pub pairs handcrafted cocktails and comfort classics in a relaxed, welcoming setting.',
                  'opening_hours' => "Daily: 4:00 PM – 12:00 AM",
              ],
              [
                  'venue_id'      => 'default-5',
                  'display_order' => 5,
                  'logo_path'     => 'assets/images/food_drink/icecream_logo.webp',
                  'image_path'    => 'assets/images/food_drink/icecream_main.avif',
                  'description'   => 'Enjoy every scoop at our dessert counter, serving handmade ice cream and indulgent sundaes all day long.',
                  'opening_hours' => "Daily: 11:00 AM – 9:00 PM",
              ],
          ];

          // ------------------------------------------------------------------
          // 2) DATABASE VENUES (optional)
          // If connection.php exists, connects fine, and a "venues" table
          // exists with rows in it, those rows are appended automatically.
          // Nothing breaks if the DB isn't set up yet.
          // ------------------------------------------------------------------
          $db_venues = [];
          $conn = null;

          if (file_exists(__DIR__ . '/connection.php')) {
              include __DIR__ . '/connection.php';
          }

          if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
              $table_check = @$conn->query("SHOW TABLES LIKE 'venues'");
              if ($table_check && $table_check->num_rows > 0) {
                  $stmt = $conn->prepare("SELECT * FROM venues ORDER BY display_order ASC, venue_id ASC");
                  if ($stmt) {
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result && $result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $db_venues[] = $row;
                          }
                      }
                      $stmt->close();
                  }
              }
          }

          // ------------------------------------------------------------------
          // 3) MERGE + SORT + RENDER
          // ------------------------------------------------------------------
          $all_venues = array_merge($default_venues, $db_venues);
          usort($all_venues, function ($a, $b) {
              return ($a['display_order'] ?? 0) <=> ($b['display_order'] ?? 0);
          });

          if (!empty($all_venues)) {
              $index = 0;
              foreach ($all_venues as $venue) {
                  $is_even = ($index % 2 === 0);

                  $logo_html = "";
                  if (!empty($venue['logo_path'])) {
                      $logo_html = '<img src="' . htmlspecialchars($venue['logo_path']) . '" class="venue-logo">';
                  }

                  $opening_html = "";
                  if (!empty($venue['opening_hours'])) {
                      $opening_html = "<h2>Opening hours</h2><p>" . nl2br(htmlspecialchars($venue['opening_hours'])) . "</p>";
                  }

                  echo '<div class="info">';

                  $img_src = !empty($venue['image_path']) ? htmlspecialchars($venue['image_path']) : 'assets/images/body_1.jpg';
                  $img_html = '<img src="' . $img_src . '" class="venue-image">';

                  $text_html = '<div class="text_content">' . $logo_html . '<p>' . htmlspecialchars($venue['description']) . '</p>' . $opening_html . '</div>';

                  if ($is_even) {
                      echo $text_html . $img_html;
                  } else {
                      echo $img_html . $text_html;
                  }
                  echo '</div>';
                  $index++;
              }
          } else {
              echo "<p style='text-align:center; padding: 50px;'>No venues available currently.</p>";
          }
        ?>
      </div>
    </div>
            <?php include'footer.php'?>
</body>
</html>