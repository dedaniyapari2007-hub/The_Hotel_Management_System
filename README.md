# The_Hotel_Management_System
The hotel management system that solving a problem of time wasting in mange the all data and providing hotel information in details,made in php.


# The Smart Hotel Hub

A PHP + MySQL web application for fast room bookings and guest services, with a separate admin panel for managing the hotel.

## Features

- **Public site**: home page, rooms listing, individual room detail pages, booking flow, food & drink page, venues page, contact form, and user registration/login.
- **Admin panel** (`/admin`): dashboard, manage rooms, bookings, guests, reviews, messages, and admin accounts, with its own login/logout.
- **Reviews**: guests can submit reviews via `submit_review.php`.

## Tech Stack

- PHP (procedural, `mysqli`)
- MySQL
- HTML/CSS (page-specific stylesheets, e.g. `rooms.css`, `book_room.css`, `login.css`)

## Requirements

- PHP 7.4+ (with `mysqli` extension)
- MySQL / MariaDB
- A local server stack such as XAMPP, MAMP, or WAMP

## Setup

1. **Clone or copy** this project into your server's web root (e.g. `htdocs/` for XAMPP).
2. **Create the database** by importing the SQL files in order:
   ```
   database.sql
   admin_schema.sql
   ```
   You can do this via phpMyAdmin or the MySQL CLI:
   ```bash
   mysql -u root -p < database.sql
   mysql -u root -p Hotel_management < admin_schema.sql
   ```
3. **Configure the database connection** in `connection.php` and `db.php` (both currently default to `host=localhost`, `user=root`, `password=""`, `database=Hotel_management`). Update these if your local MySQL uses different credentials.
4. **Start your server** (Apache + MySQL) and visit `index.php` in your browser.

## Default Admin Login

An initial super admin account is seeded by `admin_schema.sql`:
- **Email**: `admin@platinumpalace.com`
- **Password**: set at seed time (hashed in the database) — check with the project owner or reset it directly in the `admins` table if unknown.

Access the admin panel at `/admin/admin_login.php`.

## Project Structure

```
Projet/
├── admin/                # Admin panel (dashboard, management pages, includes)
├── assets/                # Images and animations
├── index.php              # Home page
├── our_rooms.php           # Rooms overview
├── room1.php ... room6.php # Individual room detail pages
├── booking.php / booking_1.php / book_room.php  # Booking flow
├── contact.php             # Contact form
├── login.php / register.php / logout.php        # Auth
├── food_drink.php          # Food & drink page
├── the_hotel.php           # About the hotel
├── navbar.php / footer.php # Shared layout includes
├── connection.php / db.php # Database connection config
├── database.sql            # Core schema + seed data (rooms, guests, bookings, etc.)
└── admin_schema.sql        # Admin accounts schema + seed super admin
```

## Notes

- There are two DB connection files (`connection.php` and `db.php`) with overlapping settings — keep them in sync if you change credentials.
- `check_img.php` and `fix.php` appear to be utility/debug scripts; review before deploying to production.
- Default credentials (`root` / no password) are meant for local development only — change them before deploying anywhere public.