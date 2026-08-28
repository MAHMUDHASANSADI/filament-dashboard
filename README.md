# Ecommerce Admin

A Laravel + Filament admin panel for managing an e-commerce store (categories, products, etc.).

**Stack:** Laravel 13 · Filament 5 · PHP 8.3

---

## Getting Started

### 1. Clone & install dependencies

```bash
git clone <repo-url>
cd ecommerce-admin
composer install
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_admin
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Build assets & start server

```bash
npm run build
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

---

## Filament Setup

Filament is already installed (`filament/filament ^5.7`). If you are setting it up from scratch on a fresh project:

```bash
# Install the package
composer require filament/filament

# Install Filament and create the admin panel
php artisan filament:install --panels

# Create an admin user
php artisan make:filament-user
```

### Useful Filament Artisan Commands

| Task                     | Command                                                                        |
| ------------------------ | ------------------------------------------------------------------------------ |
| Create a Resource        | `php artisan make:filament-resource ModelName`                                 |
| Create a RelationManager | `php artisan make:filament-relation-manager ResourceName relation titleColumn` |
| Create a Page            | `php artisan make:filament-page PageName`                                      |
| Upgrade Filament assets  | `php artisan filament:upgrade`                                                 |

---

## License

MIT
