Project: Responsive Landing Page + Material Master CRUD (PHP + MySQLi)

This project contains two parts:

1️.Responsive Landing Page (HTML + CSS + Bootstrap)
Features:
Header with navigation
Hero section with CTA
Features section using Bootstrap cards
Pricing table
Contact form (no backend)
Fully responsive UI

Path:
/landing/index.html

Open in browser:

http://localhost/platominds/landing/index.html

2️. Material Master Management System (Core PHP + MySQLi)
Fields:
Material Name (Text)
UOM (KG, Liter, Pieces, Meter)
Cost per Unit (Decimal)
Description (Optional)
Status (Active / Inactive)

CRUD Features:

1. Add Material
2. List Materials
3. Edit Material
4. Delete (Soft Delete — sets Status = Inactive)
5. Search by Name
6. Filter by Status
7. Pagination (10 rows per page)
8. Bootstrap UI
9. Prepared statements (secure)

 Database Setup

Import database.sql using phpMyAdmin
The database created will be:
platominds_tests

Table:
materials

Configure Database Connection

Edit file:

material_master/config.php


Default settings for XAMPP:

$host = 'localhost';
$db   = 'platominds_tests';
$user = 'root';
$pass = '';

:1: How to Run the Project
Landing Page:
http://localhost/platominds/landing/index.html

Material Master System:
http://localhost/platominds/material_master/list.php  

Admin data access : (provided because its technical assignment)
http://localhost/phpmyadmin/

 Folder Structure
PLATOMINDS : 
1. landing 
    1.1 index.html 
2. material_master 
    2.1 add.php
    2.2 config.php
    2.3 delete.php
    2.4 edit.php
    2.5 footer.php
    2.6 header.php
    2.7 list.php
    2.8 test_db.php
3. myassets 
    3.1 image data
4. database.sql
5. README.md

Technologies Used

PHP
MySQLi
HTML & CSS
Bootstrap 5
XAMPP