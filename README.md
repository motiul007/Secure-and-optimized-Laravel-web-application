# Secure and Optimized Laravel Web Application

## 📌 Objective

This project is a **secure, backend-focused Laravel web application** built to demonstrate expertise in:

- Multi-authentication systems
- Role-based route protection
- Real-time updates using WebSockets
- High-performance bulk product import using queues and batch processing
- Test-driven development with Laravel’s testing tools

The UI is intentionally minimal. The primary focus is **backend logic, scalability, performance, and correctness**.

---

## 🚀 Features Overview

### 1️⃣ Multiple Authentication Guards

- Separate authentication flows for:
  - **Admin**
  - **Customer**
- Independent login, registration, and dashboards
- Implemented using Laravel’s built-in guard system

#### Guards Used
- `auth:admin`
- `auth:customer`

#### Route Protection
Routes are protected using middleware per guard:

```php
Route::middleware('auth:admin')->group(function () {
    // Admin routes
});

Route::middleware('auth:customer')->group(function () {
    // Customer routes
});
2️⃣ Product Management (Admin)

Admins can manage products with full CRUD functionality.

Product Fields

name

description

price

image

category

stock

Admin Capabilities

Create products

Update products

Delete products

View paginated product listings

3️⃣ Bulk Product Import (100,000+ Records)

A high-performance bulk import system is implemented for Admin users.

Key Features

Supports CSV and Excel files

Handles 100,000+ products

Uses:

Chunked reading

Laravel queues

Background job processing

Prevents request timeouts entirely

Default Image Logic

If an image is missing in the CSV:

defaults/images.jpg


is automatically assigned to the product.

4️⃣ Optimized Import Architecture
Tools & Concepts Used

maatwebsite/excel

Laravel Queues (database driver)

Chunk processing (chunkSize = 1000)

Background workers (queue:work)

Why This Works

Low memory usage

Safe for very large datasets

Import runs outside the HTTP request lifecycle

Fully scalable and fault-tolerant

5️⃣ Real-Time Updates (WebSockets)
WebSocket Stack

Laravel Broadcasting

Presence Channels

WebSocket provider (Laravel WebSockets / Pusher)

Implemented Features

Real-time online/offline presence tracking

Tracks both:

Admin users

Customer users

Presence status:

Updated live on Admin dashboard

Stored in the database

📂 Sample Import File

The repository includes:

products_sample_import.csv


Contains demo product data

Used to test and verify bulk import functionality

Demonstrates large-scale import performance

🧪 Testing
Test Types Included

✅ Unit Test

✅ Feature Test

Covered Scenarios

Product creation

Bulk import validation logic

Core admin workflows

Run Tests
php artisan test

Setup Instructions
1️⃣ Clone the Repository
git clone https://github.com/<your-username>/Secure-and-optimized-Laravel-web-application.git
cd ecommerce-backend

2️⃣ Install Dependencies
composer install
npm install

3️⃣ Environment Configuration
cp .env.example .env
php artisan key:generate


Update .env with database credentials and queue settings:

QUEUE_CONNECTION=database

4️⃣ Database Setup
php artisan migrate
php artisan queue:table
php artisan migrate

5️⃣ Storage Link
php artisan storage:link

6️⃣ Start Queue Worker
php artisan queue:work --timeout=0


⚠️ Required for bulk imports to work.

7️⃣ Run Application
php artisan serve

📊 Architectural & Performance Decisions
Why Queues?

Avoids HTTP timeouts

Enables background processing

Improves scalability

Why Chunk Processing?

Prevents memory exhaustion

Handles large files efficiently

Why Multiple Guards?

Strong role isolation

Improved security

Cleaner authorization logic

Why Presence Channels?

Accurate real-time user presence

Ideal for admin monitoring dashboards

📁 Project Structure Highlights
app/
 ├── Imports/
 ├── Jobs/
 ├── Models/
 ├── Http/
 │    ├── Controllers/
 │    ├── Middleware/
routes/
 ├── admin.php
 ├── customer.php
resources/
 ├── views/
tests/

🎥 Screencast (Optional)

A short 3–5 minute video walkthrough can be provided covering:

Authentication flow

Product import

Queue processing

Real-time presence

Code structure
