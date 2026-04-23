# Laravel Junior Test Project

A Laravel application demonstrating CRUD operations, database relationships, user roles, and algorithmic problem solving.

## Table of Contents

- [Project Installation](#project-installation)
- [Task 1: Product Management System](#task-1-product-management-system)
- [Task 2: Database Relationships + User Roles](#task-2-database-relationships--user-roles)
- [Task 3: Longest Substring Without Repeating Characters](#task-3-longest-substring-without-repeating-characters)
- [Task 4: Group Anagrams](#task-4-group-anagrams)

## Project Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laraveljuniortest
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   ```
   Configure your database credentials in `.env` file

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```
   This creates test users and posts for the Posts system

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Products: `http://localhost:8000/products`
   - Login: `http://localhost:8000/login`
   - Register: `http://localhost:8000/register`
   - Posts: `http://localhost:8000/posts` (requires authentication)

### Seeded Users
- **Admin:** admin@example.com / password
- **Author:** author@example.com / password
- **Another Author:** author2@example.com / password

---

## Task 1: Product Management System

### Objective
Create a simple Product Management System using Laravel.

### Database Schema
**Products Table:**
- `id` - Primary key
- `name` - String (required)
- `price` - Decimal (required)
- `description` - Text (optional)
- `created_at`, `updated_at` - Timestamps

### Implementation Details

#### Migration
- File: `database/migrations/2026_04_23_124120_create_products_table.php`
- Creates products table with specified fields
- Includes decimal field for price with precision (10, 2)

#### Model
- File: `app/Models/Product.php`
- Fillable fields: `name`, `price`, `description`
- Uses Eloquent ORM for database operations

#### Controller
- File: `app/Http/Controllers/ProductController.php`
- Methods:
  - `index()` - Lists all products
  - `create()` - Shows product creation form
  - `store()` - Validates and creates new product
  - `edit()` - Shows product edit form
  - `update()` - Validates and updates product
  - `destroy()` - Deletes product

#### Validation Rules
- `name`: required, string, max 255 characters
- `price`: required, numeric, minimum 0
- `description`: optional, string

#### Routes
- Resource route: `/products`
- Full CRUD operations available
- No authentication required

#### Views
- `resources/views/products/index.blade.php` - List all products
- `resources/views/products/create.blade.php` - Create product form
- `resources/views/products/edit.blade.php` - Edit product form
- All views use Bootstrap 5 for styling

### Usage
1. Navigate to `/products`
2. Click "Create New Product" to add a product
3. View all products in the table
4. Edit or delete existing products

---

## Task 2: Database Relationships + User Roles

### Objective
Implement a Post system with User Roles.

### Database Schema

#### Users Table
- Default Laravel users table
- Added `role` column via migration (default: 'author')

#### Posts Table
- `id` - Primary key
- `user_id` - Foreign key to users table (cascade delete)
- `title` - String
- `content` - Text
- `created_at`, `updated_at` - Timestamps

### Roles
- **Admin:** Can view all posts and delete any post
- **Author:** Can create posts and view their own posts only

### Implementation Details

#### Migrations
1. `database/migrations/2026_04_23_124311_add_role_to_users_table.php`
   - Adds `role` column to users table
   - Default value: 'author'

2. `database/migrations/2026_04_23_124331_create_posts_table.php`
   - Creates posts table with foreign key constraint
   - Cascade delete on user deletion

#### Relationships
- **User Model** (`app/Models/User.php`)
  - `posts()` - hasMany relationship with Post
  - Fillable fields include 'role'

- **Post Model** (`app/Models/Post.php`)
  - `user()` - belongsTo relationship with User
  - Fillable fields: `user_id`, `title`, `content`

#### Controller
- File: `app/Http/Controllers/PostController.php`
- Methods:
  - `index()` - Shows posts based on user role
    - Admins see all posts
    - Authors see only their own posts
  - `create()` - Shows post creation form (authors only)
  - `store()` - Creates new post (authors only)
  - `show()` - Shows post details
    - Admins can view any post
    - Authors can only view their own posts
  - `destroy()` - Deletes post (admins only)

#### Role-Based Logic
- Simple column check: `$user->role === 'admin'`
- Authorization checks in controller methods
- UI elements hidden based on role (delete button, create button)

#### Authentication
- Custom AuthController for login/register/logout
- Routes: `/login`, `/register`, `/logout`
- Bootstrap-styled authentication views
- Auth middleware protects post routes

#### Routes
- Auth routes (public):
  - `GET /login` - Show login form
  - `POST /login` - Process login
  - `GET /register` - Show registration form
  - `POST /register` - Process registration
  - `POST /logout` - Logout user

- Post routes (protected by auth middleware):
  - `GET /posts` - List posts
  - `GET /posts/create` - Create post form
  - `POST /posts` - Store new post
  - `GET /posts/{id}` - Show post details
  - `DELETE /posts/{id}` - Delete post

#### Views
- `resources/views/auth/login.blade.php` - Login form
- `resources/views/auth/register.blade.php` - Registration form
- `resources/views/posts/index.blade.php` - List posts with role-based UI
- `resources/views/posts/create.blade.php` - Create post form
- `resources/views/posts/show.blade.php` - Post details
- All views use Bootstrap 5

#### Seeders
- `database/seeders/UserSeeder.php`
  - Creates 3 users (1 admin, 2 authors)
  - Password: 'password' for all users

- `database/seeders/PostSeeder.php`
  - Creates 6 posts (2 per user)
  - Demonstrates role-based functionality

### Usage
1. Register at `/register` (new users get 'author' role)
2. Login at `/login`
3. Authors can:
   - Create posts via `/posts/create`
   - View only their own posts at `/posts`
4. Admins can:
   - View all posts at `/posts`
   - Delete any post via delete button
   - Cannot create posts

---

## Task 3: Longest Substring Without Repeating Characters

### Objective
Find the length of the longest substring without repeating characters.

**Logic:**
1. Use two pointers (left and right) to define a sliding window
2. Use a hash map to store the last seen index of each character
3. Expand the window by moving the right pointer
4. When a duplicate is found, shrink the window from the left
5. Track the maximum window size encountered
6. Return both length and the actual substring

### Usage
Access at: `http://localhost:8000/longest-substring`

---

## Task 4: Group Anagrams

**Logic:**
1. For each string, sort its characters to create a key
2. All anagrams will have the same sorted key
3. Use a hash map to group strings by their sorted key
4. Return the grouped values

### Usage
Access at: `http://localhost:8000/group-anagrams`

---

## Technology Stack

- **Framework:** Laravel 11
- **PHP:** 8.1+
- **Database:** MySQL
- **Frontend:** Bootstrap 5
- **CSS Framework:** Bootstrap 5 (CDN)
- **Authentication:** Custom Laravel Auth