# 📝 Mini Blog System API (Laravel)

A secure and token-authenticated REST API built with Laravel for managing articles and categories. Supports public access to published articles, rate limiting, and user authentication.

---

## 🚀 Features

- 🔐 Authenticated login using Sanctum tokens
- ✍️ Article CRUD for authenticated users (with soft delete)
- 🗂️ Category management
- 🌐 Publicly accessible article listing and detail
- 📊 API Rate Limiting (per IP and per authenticated user)
- 🌈 Responsive navigation menu with dynamic links based on auth state

---

## ⚙️ Requirements

- Php: ^8.2
- Composer
- MySQL or MariaDB
- Node.js & NPM (for frontend asset compilation)
- Laravel 12
- Laravel Sanctum

---

## 📦 Installation

```bash
# Clone the repo
git clone https://github.com/SOBOJBANGLA/Mini-Blog-System-with-Authenticated-API.git
cd mini-blog-api

# Install PHP dependencies
composer install

# Copy .env and generate app key
cp .env.example .env
php artisan key:generate

# Configure database credentials in .env
DB_DATABASE=article
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# (Optional) Seed data
php artisan db:seed

# Install JS dependencies and compile assets
npm install
npm run dev

# Serve the app
php artisan serve
