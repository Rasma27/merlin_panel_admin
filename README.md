# MerlinMarket

MerlinMarket is a Laravel storefront and point-of-sale application. Administrators maintain the product catalog, while cashiers record sales and download PDF invoices.

## Setup

Install PHP dependencies and prepare the database:

```bash
composer install
npm install
php artisan migrate --seed
php artisan storage:link
npm run build
```

The public disk stores product images in `storage/app/public/products`. The storage link makes those images available to the storefront.

Demo accounts seeded by `DatabaseSeeder`:

| Role | Email | Password |
|---|---|---|
| Admin | admin@gmail.com | password |
| Kasir | kasir@gmail.com | password |

## Features

- The public home page displays in-stock products.
- Admins can add, edit, and remove products. Image uploads are validated, auto-oriented, rotated when requested, cropped to 1000 × 1000, watermarked with MerlinMarket, and converted to WebP using Intervention Image.
- Cashiers can create a sale with multiple products. Stock is checked and decremented transactionally.
- Cashiers can choose quick cash amounts, and each sale stores the amount received and change alongside its invoice number and item price snapshots. A printable receipt is shown after checkout; cashiers can also download the invoice as a PDF, and administrators can download any invoice.
- Product and invoice routes retain role-based access control.

The Intervention Image GD driver requires PHP GD. Demo products can be added by rerunning `php artisan db:seed`.

## Real-time order notifications (Week 10)

Laravel Reverb sends a private `admin.orders` event after a cashier transaction has been committed. Only authenticated administrators can subscribe; an admin dashboard displays new order details without reloading.

Copy the `REVERB_*` and `VITE_REVERB_*` development settings from `.env.example` into `.env` if they are missing, then run these commands in separate terminals:

```bash
php artisan serve
php artisan reverb:start
npm run dev
```

Keep the admin dashboard open in one browser and record an order from a cashier account in another. The admin page shows the invoice number, cashier, total, and invoice link as soon as the order is placed.
