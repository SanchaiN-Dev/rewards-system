<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🚀 Laravel + Vue.js Docker Setup

This repository provides a **fully containerized** Laravel + Vue.js development environment using **Docker Compose**.

---

## **📌 Features**  
✅ Laravel 10 with PHP 8.2  
✅ Vue.js (Vite) inside `resources/js`  
✅ MariaDB as the database  
✅ phpMyAdmin for database management  
✅ Nginx for serving the Laravel backend  
✅ Hot reload for Vue.js (`npm run dev`)  

---

## **📌 Prerequisites**  
Before you begin, ensure you have the following installed:  

- [Docker](https://www.docker.com/)  
- [Docker Compose](https://docs.docker.com/compose/)  
- **Optional:** [Make](https://www.gnu.org/software/make/) (for running commands easily)  

---

## **📌 Setup Instructions**  

### **1️⃣ Clone the Repository**  
```sh
git clone https://github.com/your-repo.git
cd your-repo


### **2️⃣ Configure .env File** 
cp .env.example .env

APP_URL=http://localhost:8000
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=admin
DB_PASSWORD=password

### **3️⃣ Build & Start Containers** 
docker-compose up -d --build
✅ This will:
- Install Laravel dependencies (composer install)
- Install Vue.js dependencies (npm install in resources/js)
- Run database migrations & seeders
- Start Laravel (php artisan serve)
- Start Vue.js (npm run dev)

### **4️⃣ Verify Setup** 
📌 Available Commands
🚀 Start the Project
- docker-compose up -d

🛑 Stop the Project
- docker-compose down

♻️ Restart Containers
- docker-compose restart

🛠 Access Laravel Container
- docker exec -it app bash

📜 Run Laravel Migrations
- docker exec -it app php artisan migrate --force
