# ThrivePOS

A simple **Point of Sale (POS) system** built with **Laravel**.  
This system is designed for small businesses to manage sales, inventory, and customers.

---

## Features

- Manage products, categories, and inventory  
- Process sales and track payments  
- Customer management  
- Generate sales reports  
- Responsive design for desktops and tablets  

---

## Installation

1. **Clone the repository**
```bash
git clone https://github.com/gmramil0728/thrivepos.git
cd thrivepos
Install dependencies

composer install
npm install
npm run dev
Environment setup

cp .env.example .env
php artisan key:generate
Database setup

Update .env with your database credentials

DB_DATABASE=pos_db
DB_USERNAME=root
DB_PASSWORD=
Run migrations:

php artisan migrate --seed
Storage link

php artisan storage:link
Run locally

Using built-in server (optional):

php artisan serve
Or configure Apache/Nginx for LAN access

Usage
Access the POS system via browser

Login with seeded admin account (if any)

Manage products, process sales, and view reports

Tech Stack
Backend: Laravel 10, PHP 8.x

Frontend: Bootstrap 5, jQuery

Database: MySQL

Others: Composer, Node.js/NPM for assets

Notes
.env file is not included for security

Use .env.example as a template

Make sure /storage and /bootstrap/cache are writable

License
This project is for demo / learning purposes.

