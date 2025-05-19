# 6AmTechTask Assignment

## Project Setup

1. **Clone the Repository**
   ```bash
   git clone <your-repo-url>
   cd <project-directory>
   ```

2. **Copy Environment File**
   ```bash
   cp .env.example .env
   ```

3. **Configure Database**
   - Edit `.env` and set your database credentials:
     ```
     DB_DATABASE=your_db
     DB_USERNAME=your_user
     DB_PASSWORD=your_password
     ```

4. **Install Dependencies**
   ```bash
   composer install
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders**
   ```bash
   php artisan migrate --seed
   ```
   - This will create all tables and seed 20,000+ products for order management testing.

7. **Start the Application**
   ```bash
   php artisan serve
   ```

---

## Task Guidelines

### Task 1: User Authentication & Role-Based Dashboard
- **Custom authentication** with role-based dashboards (Admin, User).
- Middleware restricts access to routes based on user roles.
- Proper validation and error handling for login, registration, and dashboard access.
- See: `routes/web.php`, `app/Http/Controllers/Auth/LoginController.php`, `app/Http/Controllers/Auth/RegisterController.php`, `app/Http/Requests/Auth/LoginRequest.php`, `app/Http/Requests/Auth/RegisterRequest.php`, `app/Services/Auth/LoginService.php`, `app/Services/Auth/RegisterService.php`

### Task 2: RESTful API for Blog System
- Full CRUD for blog posts via RESTful API.
- Uses Laravel API resources for consistent responses.
- JWT authentication for API endpoints.
- Validation, error handling, and OpenAPI/Swagger-style documentation.
- **API Access:**
  - Pass header: `ApiAccessToken: 6AmTechTask`
- **API Endpoints:**
  - **Login:**
    - **Route:** `POST /api/v1/auth/login`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Content-Type: application/json
      ```
    - **Body:**
      ```json
      {
        "email": "user@example.com",
        "password": "your_password"
      }
      ```
  - **Get All Posts:**
    - **Route:** `GET /api/v1/user/posts`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Authorization: Bearer <your_jwt_token>
      ```
  - **Get Post by ID:**
    - **Route:** `GET /api/v1/user/posts/{id}`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Authorization: Bearer <your_jwt_token>
      ```
  - **Create Post:**
    - **Route:** `POST /api/v1/user/posts`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Authorization: Bearer <your_jwt_token>
      Content-Type: application/json
      ```
    - **Body:**
      ```json
      {
        "title": "Your Post Title",
        "content": "Your post content here.",
        "image": "Upload Image" 
      }
      ```
  - **Update Post:**
    - **Route:** `POST /api/v1/user/posts/{id}/update`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Authorization: Bearer <your_jwt_token>
      Content-Type: application/json
      ```
    - **Body:**
      ```json
      {
        "title": "Updated Post Title",
        "content": "Updated post content here.",
        "image": "Upload Image"
      }
      ```
  - **Delete Post:**
    - **Route:** `DELETE /api/v1/user/posts/{id}`
    - **Headers:**
      ```
      ApiAccessToken: 6AmTechTask
      Authorization: Bearer <your_jwt_token>
      ```
- See: `routes/api.php`, `routes/api_v1.php`,`app/Http/Controllers/Api/V1/Auth/LoginController.php`, `app/Services/Api/V1/Auth/LoginService.php` ,`app/Http/Controllers/Api/V1/User/PostController.php`, `app/Services/Api/V1/User/PostService.php`

### Task 3: Optimizing Database Queries for Order Management

**Models:** User, Product, Order, OrderDetail.

**Seeder:** Populates the database with products and a large number of orders for realistic performance testing.

**🔧 Optimizations Applied:**

- **Eager Loading (with)**
  - Used to avoid N+1 query issues when retrieving orders and their related details and products.
  - See: `OrderService.php → getUserOrders()`.

- **Indexing**
  - Indexes added on foreign keys like `user_id`, `order_id`, and `product_id` in the orders and order_details tables.
  - Improves filtering and join performance.

- **Pagination**
  - Orders are paginated to limit the number of records fetched in a single request.
  - Environment variable `PAGINATION_LIMIT` controls the number of results per page.

- **Query Caching**
  - Expensive query results are cached using Laravel's Cache facade.
  - Cache key structure: `user_orders_{user_id}_page_{page_number}`.
  - Cached data is automatically refreshed after the TTL (5 minutes).
  - Orders are manually invalidated when a new order is created (via `Cache::forget()`).
  - See: `OrderService.php → getUserOrders()` and `createOrder()`.

**📊 Performance Comparison**

| Metric                | Before Caching | After Caching |
|-----------------------|----------------|---------------|
| Query Execution Time  | 0.03891396522522 sec | 0.0036709308624268 sec |

**⏱️ Measured using microtime(true) difference and Laravel Debugbar.**

**📂 File References**

- **Service:** `app/Services/User/OrderService.php`
- **Controller:** `app/Http/Controllers/User/OrderController.php`
- **Routes:** `routes/web.php`

### Task 4: File Upload System with Queued Processing
- Users can upload files (images).
- Files are processed in the background using Laravel Queues (e.g., image resizing, thumbnail generation).
- Files stored securely on local.
- Queue jobs handle processing and error management.
- **How it works:**
  - The upload request is handled by `app/Http/Controllers/User/FileUploadController.php`.
  - Validation is performed by `app/Http/Requests/User/FileUploadRequest.php`.
  - The actual upload and job dispatching is handled by `app/Services/User/FileUploadService.php`.
  - Each file is processed asynchronously by `app/Jobs/ProcessUploadedFileJob.php` (e.g., image resizing, thumbnail generation).
  - Errors during processing are logged and handled gracefully.
---

## Code Structure
- **Controllers:** All business logic entry points (see `app/Http/Controllers/`)
- **Services:** Business logic and data handling (see `app/Services/`)
- **Requests:** Validation (see `app/Http/Requests/`)
- **Models:** Eloquent models (see `app/Models/`)
- **Migrations/Seeders:** Database structure and test data (see `database/migrations/`, `database/seeders/`)
- **Views:** Blade templates for web UI (see `resources/views/`)
- **Routes:**
  - Web: `routes/web.php`
  - API: `routes/api.php`, `routes/api_v1.php`

---

## Optimization Techniques (Order Management)
- **Eager Loading:** Used `with()` to load related models and avoid N+1 queries.
- **Indexing:** Added indexes to foreign keys for faster lookups.
- **Query Caching:** Used cache for expensive queries where appropriate.
- **Pagination:** Used order lists to improve performance and UX.
- **Performance Measurement:** Used Laravel Debugbar and microtime to measure and visualize query performance.

---
