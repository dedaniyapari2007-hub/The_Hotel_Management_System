CREATE TABLE IF NOT EXISTS admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','super_admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (full_name, email, password_hash, role)
VALUES ('Super Admin', 'admin@platinumpalace.com', '$2y$10$Py4ztXMGfZr3zowtArgsr.3RUDSn4ePMnq7CwigJykYxGGhYrSZUe', 'super_admin');
