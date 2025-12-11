CREATE DATABASE IF NOT EXISTS platominds_tests CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE platominds_tests;

CREATE TABLE IF NOT EXISTS materials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  material_name VARCHAR(255) NOT NULL,
  uom ENUM('KG','Liter','Pieces','Meter') NOT NULL,
  cost_per_unit DECIMAL(13,2) NOT NULL,
  description TEXT NULL,
  status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO materials (material_name, uom, cost_per_unit, description, status)
VALUES ('Cement', 'KG', 7.50, 'Ordinary Portland Cement', 'Active'),
       ('Paint', 'Liter', 120.00, 'Exterior paint', 'Active');
