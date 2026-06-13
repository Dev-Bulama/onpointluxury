# On Point Luxury

> **Premium Apartment & Hotel Bookings in Nigeria**

On Point Luxury is a full-featured luxury property booking platform built with Laravel 11. It allows guests to discover and book premium short-let apartments, serviced residences, and boutique hotels across Lagos, Abuja, and Port Harcourt — with secure Paystack payment integration and WhatsApp inquiry support.

---

## Features

- **Property Listings** — Browse, filter, and search properties by type, location, guests, price, and bedrooms
- **Secure Bookings** — Full booking flow with server-side Paystack payment verification
- **WhatsApp Integration** — One-tap WhatsApp booking and inquiry with dynamic pre-filled messages
- **Role-Based Access** — Admin, Manager, and Client dashboards
- **CMS** — Manage pages, menus, blog posts, FAQs, and testimonials from the admin panel
- **Mobile-Ready** — Fully responsive with fixed mobile bottom navigation
- **Email Notifications** — Booking confirmation emails (graceful SMTP fallback)
- **Admin Panel** — Complete property, booking, payment, and user management

---

## Requirements

- PHP 8.3 or higher
- MySQL 8.0+ or MariaDB 10.6+
- Composer 2.x
- Node.js (optional — only if compiling custom assets; project uses Tailwind CDN)

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/dev-bulama/onpointluxury.git
cd onpointluxury
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=onpointluxury
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Run Migrations and Seed

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- 3 default users (admin, manager, client)
- 12 luxury properties with images
- Property types, categories, and amenities
- FAQs, testimonials, blog posts
- CMS pages (About, Privacy, Terms, etc.)
- Default site settings

### 6. Link Storage

```bash
php artisan storage:link
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

---

## Login Credentials

After running `php artisan migrate --seed`, use these credentials:

| Role    | Email                        | Password | Dashboard URL         |
|---------|------------------------------|----------|-----------------------|
| Admin   | admin@onpointluxury.com      | password | /admin/dashboard      |
| Manager | manager@onpointluxury.com    | password | /manager/dashboard    |
| Client  | client@onpointluxury.com     | password | /client/dashboard     |

> **IMPORTANT:** Change all passwords immediately after first login in production.

---

## Environment Setup

### Paystack Payment Gateway

1. Sign up at [paystack.com](https://paystack.com)
2. Get your test/live API keys
3. Go to Admin Panel → Settings → Paystack
4. Enter your Public Key and Secret Key
5. Set mode to `test` for development, `live` for production

Or set in `.env`:

```env
PAYSTACK_PUBLIC_KEY=pk_test_xxxxxxxxxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxxxxx
```

### SMTP Email

Go to Admin Panel → Settings → SMTP, or set in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@onpointluxury.com
MAIL_FROM_NAME="On Point Luxury"
```

> If SMTP is not configured, email sending fails silently (booking still processes normally).

### WhatsApp

Go to Admin Panel → Settings → WhatsApp and enter your WhatsApp number in international format without the `+` sign (e.g., `2348012345678`).

---

## Deployment

### Production Deployment

Run the deployment script:

```bash
bash deploy.sh
```

This script:
1. Installs production PHP dependencies
2. Enables maintenance mode
3. Clears all caches
4. Runs database migrations
5. Seeds the database (idempotent)
6. Links storage
7. Rebuilds config, route, and view caches
8. Brings the site back online

### Fresh Install (Development Only)

> WARNING: This destroys all database data. Use in dev only.

```bash
bash fresh-install.sh
```

---

## Important Routes

| Route                  | Description                    |
|------------------------|--------------------------------|
| `/`                    | Homepage                       |
| `/properties`          | Browse all properties          |
| `/properties/{slug}`   | Property detail & booking      |
| `/booking/{property}`  | Booking form                   |
| `/payment/callback`    | Paystack payment callback      |
| `/contact`             | Contact form                   |
| `/about`               | About page                     |
| `/blog`                | Blog listing                   |
| `/login`               | Login (all roles)              |
| `/register`            | New client registration        |
| `/admin/dashboard`     | Admin panel                    |
| `/manager/dashboard`   | Manager panel                  |
| `/client/dashboard`    | Client dashboard               |

---

## Admin Panel Sections

- **Dashboard** — Key metrics and recent activity
- **Properties** — Full property CRUD with image management
- **Bookings** — View, update, and manage all bookings
- **Payments** — Payment history and verification
- **Users** — Manage admins, managers, and clients
- **Blog** — Create and manage blog posts
- **FAQs** — Manage frequently asked questions
- **Testimonials** — Curate guest testimonials
- **Pages** — CMS for About, Privacy, Terms, etc.
- **Menus** — Manage header and footer navigation
- **Messages** — View contact form submissions
- **Settings** — General, Paystack, SMTP, WhatsApp, SEO, Booking

---

## Troubleshooting

### 500 Internal Server Error

```bash
php artisan optimize:clear
tail -50 storage/logs/laravel.log
```

### Sessions Not Working

```bash
php artisan session:table
php artisan migrate
```

### Storage Images Not Showing

```bash
php artisan storage:link
```

### Database Connection Refused

Ensure MySQL/MariaDB is running:

```bash
sudo service mysql start
```

### Cache Issues After Code Changes

```bash
php artisan optimize:clear
php artisan view:clear
```

---

## Production Notes

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Use a proper web server (Nginx or Apache) — not `php artisan serve`
3. Set up SSL/HTTPS (required for Paystack in live mode)
4. Change all default passwords before launch
5. Replace Paystack test keys with live keys before accepting real payments
6. Configure real SMTP credentials for email delivery
7. Set up regular database backups

---

## Tech Stack

- **Backend:** Laravel 11 (PHP 8.3+)
- **Database:** MySQL / MariaDB
- **Frontend:** TailwindCSS CDN + Alpine.js
- **Icons:** Font Awesome 6
- **Payments:** Paystack
- **Fonts:** Inter (Google Fonts)

---

## License

MIT License. Built for On Point Luxury.
