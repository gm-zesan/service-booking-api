# Service Booking API

A simple Laravel API-based service booking system with Admin and Customer functionality.

---

## Project Overview

This project is a **Service Booking System** built with **Laravel**. It allows:

- Customers to register, login, view services, and book a service.
- Admin to login, manage services (create, update, delete), and view all bookings.
- API authentication using **Laravel Sanctum**.
- Feature testing using **PHPUnit**.
- API documentation via **Swagger** and **Postman Collection**.

---

## Features

### Customer
- Register & login
- View available services
- Book services
- View own bookings

### Admin
- Login (pre-seeded)
- CRUD operations for services
- View all bookings

---

## Live API

The Service Booking API is now live and accessible at:

**Base URL:** [http://service-booking.deshicreative.com](http://service-booking.deshicreative.com)


---


## Installation & Setup

1. Clone the repository:
```bash
git clone https://github.com/gm-zesan/service-booking-api.git
cd service-booking-api
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Environment setup:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=service_booking
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrate & seed database:
```bash
php artisan migrate --seed
```

6. Admin credentials:
```bash
Email: admin@gmail.com
Password: 12345678
```

7. Serve the project:
```bash
php artisan serve
```


## API Documentation
- Swagger UI: http://127.0.0.1:8000/api/documentation
- Postman Collection: docs/ServiceBookingAPI.postman_collection.json
- Postman Environment: docs/ServiceBookingAPI.postman_environment.json


## Running Tests
Tests cover:

- Admin creating services
- Customer booking services
- Validation for booking past dates

```bash
php artisan test
```

## Sample Outputs
1) Customer Registers & Login
```bash
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}

Response:
{
    "message": "User registered successfully",
    "data": {
        "id": 2,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOi..."
}
```


2) Admin Creates Service
```bash
POST /api/services
{
    "name": "Plumbing",
    "description": "Fix pipes and leaks",
    "price": 500,
    "status": "active"
}

Response:
{
    "message": "Service created",
    "data": {
        "id": 1,
        "name": "Plumbing",
        "description": "Fix pipes and leaks",
        "price": 500,
        "status": "active"
    }
}
```

3) Customer Books a Service
```bash
POST /api/bookings
{
    "service_id": 1,
    "booking_date": "2025-08-20"
}

Response:
{
    "message": "Service booked successfully",
    "data": {
        "id": 1,
        "user_id": 2,
        "service_id": 1,
        "booking_date": "2025-08-20",
        "status": "pending"
    }
}
```