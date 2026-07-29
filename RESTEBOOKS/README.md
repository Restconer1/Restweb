# RESTEBOOKS — Premium Ebook Subscription Platform

A PHP 8.1+ MVC scaffold implementing the core RESTEBOOKS flow: browse →
paywall → subscribe (Paystack) → download, plus a user dashboard and an
admin dashboard for managing books, users, and payments.

## What's implemented

- Full MVC skeleton (`app/Core`: Router, Controller, Model, Database, Auth, Jwt)
- MySQL schema covering every table in the spec (`database/migrations/001_create_tables.sql`)
- Seed data: roles, a default admin, all 20 categories (`database/seeders/seed.sql`)
- Session-based auth for users + a separate admin guard, with brute-force
  throttling, CSRF tokens on every form, bcrypt password hashing
- Paywall logic exactly as specified: visitor → login → subscribe → download
- Paystack integration with a **stub mode** (default) that simulates a
  successful payment locally, and a real-API code path you can switch to
  once you add live keys
- Secure ebook uploads: files are validated by extension **and** sniffed
  MIME type, then stored **outside the web root** (`storage/ebooks`) —
  they're only reachable through the authenticated download route, never
  by direct URL. Cover images are stored under `public/uploads/covers`
  since those are meant to be publicly viewable.
- User dashboard: overview, library/downloads, bookmarks, subscription
  status, payment history, profile
- Admin dashboard: stats + Chart.js revenue chart, book upload/list/delete,
  user list/suspend/reactivate/delete
- A minimal JWT-guarded REST API (`routes/api.php`) for a future mobile client
- Dark navy / neon purple-blue glassmorphism UI per the design brief,
  built with Tailwind-style utility CSS, AOS scroll animations, Font Awesome

## What's NOT yet built (next iteration)

- In-browser PDF/EPUB reader
- Blog/CMS, ticket system, newsletters
- Admin screens for Categories, full Payments log, Analytics exports,
  Settings, Activity Logs (sidebar links are placeholders for now)
- Real email sending for verification/password reset (currently stubbed —
  the flow works, but no email is actually sent)
- Bulk upload, draft/approval workflow
- Automated tests

## Requirements

- PHP 8.1+
- MySQL 5.7+/8.0
- Composer (optional — the app has a fallback autoloader, but run
  `composer install` to get `firebase/php-jwt` and `vlucas/phpdotenv`
  for production use)

## Setup

1. Copy the environment file and fill in real values:
   ```
   cp .env.example .env
   ```
2. Create the database and import the schema + seed data:
   ```
   mysql -u root -p -e "CREATE DATABASE restebooks CHARACTER SET utf8mb4"
   mysql -u root -p restebooks < database/migrations/001_create_tables.sql
   mysql -u root -p restebooks < database/seeders/seed.sql
   ```
3. (Optional but recommended) install Composer dependencies:
   ```
   composer install
   ```
4. Point your webserver's document root at `public/`, or for local
   testing run PHP's built-in server from the project root:
   ```
   php -S localhost:8000 -t public
   ```
5. Visit `http://localhost:8000`.

### Default admin login

The seeder inserts `admin@restebooks.test` — **the seeded password hash
is a placeholder and will not match any password.** Generate your own
hash and update it before first use:

```php
php -r "echo password_hash('YourNewPassword123!', PASSWORD_BCRYPT), PHP_EOL;"
```

Then update the `admins` row's `password_hash` with the output, or run:

```sql
UPDATE admins SET password_hash = '<paste the hash here>' WHERE email = 'admin@restebooks.test';
```

### Switching Paystack from stub to live

In `.env`, set:

```
PAYSTACK_MODE=live
PAYSTACK_PUBLIC_KEY=pk_live_or_test_...
PAYSTACK_SECRET_KEY=sk_live_or_test_...
```

With `PAYSTACK_MODE=stub` (the default), clicking "Subscribe Now" skips
the real Paystack API and immediately activates a subscription locally —
useful for demoing/testing the paywall flow without live keys.

## Folder structure

```
RESTEBOOKS/
  app/
    Controllers/   Models/   Views/   Middlewares/   Helpers/   Core/
  config/          app.php, database.php
  public/          index.php (front controller), assets/, uploads/covers/
  storage/         ebooks/ (private), covers/ (unused — see uploads/), logs/
  routes/          web.php, api.php
  database/        migrations/, seeders/
```

## Security notes for going to production

- Set `APP_ENV=production` in `.env` (disables error display)
- Set real, random values for `APP_KEY` and `JWT_SECRET`
- Serve over HTTPS so the `secure` session-cookie flag takes effect
- Replace the seeded admin password hash immediately (see above)
- Consider adding a WAF/rate-limiter at the edge in addition to the
  in-app login throttling
- Review file upload limits (`MAX_EBOOK_BYTES` in `AdminBookController`)
  against your hosting provider's PHP `upload_max_filesize`/`post_max_size`
