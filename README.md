# Overview

This backend application provides a REST API for an e-commerce platform. It allows users to add/remove items from a cart (stored in Redis), place orders, and view their order history. Built using Laravel, it follows best practices for scalability, testability, and maintainability.

## Features
### Cart Management

Add items to the cart.
Remove items from the cart.
View all items in the cart.

## Order Management

Place an order.
View order history.
Database

Orders and order items are stored in a MySQL/PostgreSQL database.
Error Handling

Proper HTTP status codes with clear error messages.
Testing

Comprehensive unit and feature tests for critical functionalities.
Requirements
PHP >= 8.1
Laravel >= 10
Redis (for cart storage)
MySQL/PostgreSQL
Composer
Docker (optional for containerized setup)
Installation
Clone the Repository
bash
Copy code
git clone [https://github.com/HillaArts/laravel_ecommerce_backend.git](https://github.com/HillaArts/laravel_ecommerce_backend.git)
cd ecommerce_backened  
Install Dependencies
bash
Copy code
composer install  
Set Up Environment Variables
Copy the .env.example file to .env and update the necessary configuration, including:

Database credentials.
Redis configuration.
Application key.
bash
Copy code
cp .env.example .env  
php artisan key:generate  
Migrate and Seed the Database
Run the following commands to set up the database schema and seed the required data:

bash
Copy code
php artisan migrate --seed  
Start Redis
Ensure Redis is running. You can start Redis locally or via Docker:

bash
Copy code
docker run --name redis -p 6379:6379 -d redis  
Start the Application
Start the Laravel development server:

bash
Copy code
php artisan serve  
API Endpoints
Authentication
Login: POST /api/login
Register: POST /api/register
Cart Management
Add to Cart: POST /api/cart
Remove from Cart: DELETE /api/cart/{productId}
View Cart: GET /api/cart
Order Management
Place Order: POST /api/orders
View Orders: GET /api/orders
Project Structure
plaintext
Copy code
app/  
├── Http/  
│   ├── Controllers/           # CartController, OrderController  
│   ├── Middleware/  
│   └── Requests/              # Form requests for validation  
├── Models/                    # User, Order, OrderItem  
├── Services/                  # CartService  
├── Traits/                    # Reusable traits  
database/  
├── migrations/                # Database schema  
├── factories/                 # Model factories for testing  
└── seeders/                   # Database seeders  
routes/  
├── api.php                    # API routes  
├── web.php  
tests/  
├── Feature/                   # Feature tests for Cart and Orders  
├── Unit/                      # Unit tests for services and models  
.env                           # Configuration file  
Testing
Run Tests
bash

php artisan test  
Coverage
Feature Tests: Test the integration of API endpoints for Cart and Orders.
Unit Tests: Validate the business logic in CartService and models.
