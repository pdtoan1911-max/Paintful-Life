# Paintful Life — Local setup guide

This document explains how to set up and run the Paintful Life Laravel project locally (Windows). It covers prerequisites, environment configuration, installing dependencies, building assets, database setup and common troubleshooting.

---

## Prerequisites

- PHP 8.2+ (ensure `php` is on your PATH)
- Composer (getcomposer.org)
- Node.js (16+) and `npm` or `pnpm`
- A database: MySQL / MariaDB / PostgreSQL or SQLite
- Git (optional)

Note: this guide assumes Windows environment (paths and commands shown). Use equivalent Unix commands on macOS/Linux.

---

## 1. Get the code

Open a terminal in the project folder (e.g. `D:\work\Paintful\paintful-life`).

If you haven't cloned the repo:

```powershell
git clone <repo-url> paintful-life
cd paintful-life
```

---

## 2. Install PHP dependencies

```powershell
composer install
```

If you need to copy `.env`:

```powershell
copy .env.example .env
```

Generate app key:

```powershell
php artisan key:generate
```

---

## 3. Configure environment

Edit `.env` to set database and other values. Example using SQLite (quick local setup):

```ini
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# for sqlite create an empty file database/database.sqlite
DB_DATABASE="${PWD}\\database\\database.sqlite"
```

Or for MySQL:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paintful
DB_USERNAME=root
DB_PASSWORD=secret
```

After editing `.env`, run:

```powershell
php artisan config:clear
php artisan cache:clear
```

---

## 4. Database: migrations & seeders

Create the database (if using SQLite create `database\database.sqlite` file):

```powershell
# sqlite
if (-Not (Test-Path database\database.sqlite)) { ni database\database.sqlite -ItemType File }

# run migrations
php artisan migrate

# (optional) run seeders
php artisan db:seed
```

---

## 5. Build frontend assets (Vite)

Install Node deps and build assets. This produces `public/build/manifest.json` used by Blade.

```powershell
npm install
npm run build
```

For development with automatic rebuilds, run the dev server (in separate terminal):

```powershell
npm run dev
```

If you see `Vite manifest not found` errors, ensure `npm run build` has been executed or `npm run dev` is running during development.

---

## 6. Storage link and permissions

Create the storage symlink used for public files (Windows requires admin or Developer Mode):

```powershell
php artisan storage:link
```

---

## 7. Serve the application

Run the built-in PHP server:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Open http://127.0.0.1:8000 in your browser.

---

## Troubleshooting / common errors

- `Vite manifest not found` — run `npm run build` or `npm run dev`.
- Blade parse errors (e.g. `Unclosed '(' does not match '}'`) — check recently edited Blade templates; run `php artisan view:clear` to remove compiled views.

Commands to clear caches (helpful when changes aren't reflected):

```powershell
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
