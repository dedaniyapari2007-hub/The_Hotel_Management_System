CREATE DATABASE Hotel_management;
USE Hotel_management;

-- Rooms shown on our_rooms.php
CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL,       -- e.g. "Platinum Premium Room"
    room_type VARCHAR(50),                 -- e.g. "Luxury", "Economy"
    description TEXT,
    price_per_night DECIMAL(10,2) NOT NULL,
    max_occupancy INT DEFAULT 2,
    image_path VARCHAR(255),               -- e.g. assets/images/luxury_2.jpg
    status ENUM('available','occupied','maintenance') DEFAULT 'available'
);

-- Guests (needed once you build real booking/contact flow)
CREATE TABLE guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings ("Book Now" buttons across every page)
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT,
    room_id INT,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    total_amount DECIMAL(10,2),
    status ENUM('confirmed','checked_in','checked_out','cancelled') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guest_id) REFERENCES guests(guest_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- Contact form submissions (contact.php)
CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE
);

-- Guest reviews (rotating carousel on index.php)
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    reviewer_name VARCHAR(100) NOT NULL,
    title VARCHAR(100),                    -- e.g. "Dreamy Environment"
    review_text TEXT NOT NULL,
    rating INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Food & Drink venues (food_drink.php)
CREATE TABLE venues (
    venue_id INT AUTO_INCREMENT PRIMARY KEY,
    venue_name VARCHAR(100) NOT NULL,      -- e.g. "Belgio", "Tonga Bar"
    description TEXT,
    opening_hours VARCHAR(255),
    logo_path VARCHAR(255),
    image_path VARCHAR(255),
    display_order INT DEFAULT 0
);

-- Login accounts (for your navbar's login icon)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE registation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    conform_pass VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


USE Hotel_management;

INSERT INTO rooms (room_name, room_type, description, price_per_night, max_occupancy, image_path, status)
VALUES (
    'Platinum Premium Room',
    'Luxury',
    'A refined escape crafted for comfort, space and quiet luxury. Spacious retreat with elegant interiors, a plush king-size bed and floor-to-ceiling views.',
    6500.00,
    3,
    'assets/images/luxury_2.jpg',
    'available'
);

USE Hotel_management;

INSERT INTO rooms (room_id, room_name, room_type, description, price_per_night, max_occupancy, image_path, status) VALUES
(2, 'Luxury Twin Room', 'Luxury',
 'The Luxury Twin Room features two elegantly appointed single beds in a bright, generously sized layout. Ideal for guests travelling together who still want their own space, without compromising on Platinum Palace comfort.',
 5200.00, 2, 'assets/images/room_2.jpg', 'available'),

(3, 'Superior King Room', 'Superior',
 'The Superior King Room combines a spacious layout with a plush king-size bed and warm, contemporary decor. A well-appointed workspace and premium bathroom amenities make it a favourite among both business and leisure travellers.',
 5800.00, 3, 'assets/images/room_1.jpg', 'available'),

(4, 'Economy Sweet Room', 'Economy',
 'The Economy Sweet Room is a compact, comfortable option for guests who want a good night''s sleep without the extras. Clean, simply furnished and well-maintained, it delivers solid value for a short stay.',
 3600.00, 2, 'assets/images/room_3.jpg', 'available'),

(5, 'Economy Single Room', 'Economy',
 'Designed for solo travellers, the Economy Single Room offers a comfortable single bed, a clean private bathroom and all the basics you need for a convenient, affordable stay.',
 2400.00, 1, 'assets/images/economy.jpg', 'available'),

(6, 'Economy Twin Room', 'Economy',
 'The Economy Twin Room pairs two comfortable single beds with simple, clean decor — a practical choice for friends or colleagues who want their own space without paying for extras they won''t use.',
 3000.00, 2, 'assets/images/economy_2.jpg', 'available');