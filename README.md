# ☕ Premium Cafeteria Management System

A comprehensive PHP-based cafeteria management system built with custom MVC architecture, Bootstrap 5, and MySQL. The system features a modern premium dark theme, allowing users to browse and order food items, while administrators can manage products, users, and orders with a professional interface.

## ✨ Latest Updates (Modernization Complete)

### 🎨 Complete Design Overhaul
- ✅ **Unified Design System**: Created `css/modern.css` with 30+ reusable component classes
- ✅ **Dark Premium Theme**: Implemented coffee-themed dark design (#1a1a1a, #d4a574, #8b6f47)
- ✅ **Component Library**: Standardized buttons, cards, forms, badges, tables, and alerts
- ✅ **Reusable Navbar**: Created `views/components/navbar.php` for consistent navigation
- ✅ **CSS Variables**: Centralized color management for easy theme adjustments

### 🔄 Complete Page Modernization
- ✅ **Orders Page**: Complete redesign with modern card layout, filters, and sorting
- ✅ **Admin Users**: Modernized with dark theme, two-column layout, modern forms
- ✅ **Consistent Styling**: All pages now use unified modern.css design system

### 🧹 Code Cleanup
- ✅ **Removed Duplicates**: Deleted 5 old/duplicate view files
- ✅ **Cleaned Documentation**: Removed 9 redundant markdown files and screenshots
- ✅ **Removed Unused Files**: Deleted unused template files and layout components
- ✅ **Optimized Structure**: Cleaner, more maintainable codebase

### ⚡ Performance & Organization
- ✅ **Centralized CSS**: Eliminated inline style duplication across pages
- ✅ **Component Architecture**: Reusable navbar and CSS component system
- ✅ **Responsive Design**: Mobile-first approach with optimized breakpoints
- ✅ **Smooth Animations**: Transitions and hover effects throughout

## 📋 Features

### User Features
- ✅ **User Authentication**: Secure login/registration with bcrypt password hashing
- ✅ **Product Browsing**: Browse cafeteria items with modern dark theme
- ✅ **Search & Filter**: Search products by name and filter by category
- ✅ **Order Management**: Create orders with real-time price calculations
- ✅ **Order History**: View all orders with detailed status tracking
- ✅ **Order Filtering**: Filter by date range and status
- ✅ **Order Cancellation**: Cancel orders with confirmation dialog
- ✅ **User Profile**: Manage personal information (room, extension, building)
- ✅ **Profile Pictures**: Upload and display profile pictures

### Admin Features
- ✅ **Product Management**: Add, edit, delete products with images
- ✅ **User Management**: Manage user accounts and roles
- ✅ **Order Management**: View and manage all orders with status updates
- ✅ **Order Details**: Access complete order items and calculations
- ✅ **Status Tracking**: Update order status (Pending → Processing → Out for Delivery → Done)
- ✅ **Admin Dashboard**: Dedicated admin area with protected routes
- ✅ **Role-Based Access**: User and Admin role separation
- ✅ **Reporting**: Track orders and user activity

## 🏗️ Project Structure

```
PHP_Project/
├── index.php                      # Main application entry point and router
├── config/
│   └── dp.php                    # Database configuration and Service base class
├── core/
│   ├── Router.php                # URL routing and request dispatching
│   ├── controller.php            # Base Controller class
│   └── model.php                 # Base Model class
├── controllers/
│   ├── authController.php        # Authentication logic
│   ├── productController.php     # Product CRUD operations
│   ├── orderController.php       # Order management
│   ├── chechController.php       # Checkout process
│   └── userController.php        # User management
├── models/
│   ├── users.php                # User model with authentication
│   ├── products.php             # Product model with image handling
│   ├── order.php                # Order model with calculations
│   ├── orderItem.php            # Order item model
│   └── category.php             # Category model
├── views/
│   ├── components/
│   │   └── navbar.php           # Reusable modern navbar component
│   ├── auth/
│   │   ├── login.php            # Modern login form
│   │   └── register.php         # Modern registration form
│   ├── user/
│   │   ├── home.php             # Modern home/dashboard page
│   │   └── my_order.php         # Modern products browsing page
│   ├── admin/
│   │   ├── products.php         # Modern product management
│   │   ├── users.php            # Modern user management
│   │   └── orders.php           # Modern order management
│   ├── order/
│   │   └── create.php           # Order creation form
│   └── orders.php               # User order history with filters
├── css/
│   ├── modern.css               # NEW: Unified modern design system (630+ lines)
│   └── custom.css               # Legacy custom styles
└── uploads/                      # Product and user image storage
```

## 🎨 Modern Design System

### modern.css - Unified Component Library
A comprehensive CSS file (630+ lines) providing:

**Color System**
- Primary: `#d4a574` (Coffee Gold)
- Primary Dark: `#8b6f47` (Dark Coffee)
- Background: `#1a1a1a` (Deep Dark)
- Light Text: `rgba(255, 255, 255, 0.85)`
- Muted Text: `rgba(255, 255, 255, 0.65)`
- Border: `rgba(255, 255, 255, 0.1)`

**Reusable Component Classes**
- `.navbar-modern` - Modern navigation bar with responsive hamburger menu
- `.page-header` - Page title with gradient background
- `.card-modern` - Modern card container with hover effects
- `.btn-primary-modern` - Primary button with coffee color
- `.btn-secondary-modern` - Secondary button variant
- `.form-control-modern` - Modern form input field with dark theme
- `.form-select-modern` - Modern select dropdown
- `.badge-modern` - Badge component
- `.status-pending`, `.status-processing`, `.status-out-for-delivery`, `.status-done`, `.status-cancelled` - Color-coded status badges
- `.product-card` - Product display card with image and details
- `.order-card` - Order display card with items list
- `.table-modern` - Modern table styling with hover effects
- `.btn-icon-*` - Icon buttons for actions (edit, delete, view)
- `.empty-state` - Empty state message styling
- `.filter-section` - Filter controls styling

**Features**
- CSS Variables for easy theme customization
- Smooth transitions and hover animations
- Responsive breakpoints (mobile, tablet, desktop)
- Gradient backgrounds and shadow effects
- Full dark theme support

## 🔄 Component Architecture

### Navbar Component (`views/components/navbar.php`)
Reusable navigation bar included in all pages:
```php
<?php include 'components/navbar.php'; ?>
```
Features:
- Session-based authentication checking
- Conditional admin menu items
- Responsive Bootstrap navbar with hamburger
- Links to: Home, Menu, About, Contact, Dashboard, Orders, Users
- Login/Register/Logout based on auth state

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    room VARCHAR(50),
    ext VARCHAR(20),
    building VARCHAR(50),
    profile_picture VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Categories Table
```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Products Table
```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

### Orders Table
```sql
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    status ENUM('pending', 'processing', 'out-for-delivery', 'done', 'cancelled') DEFAULT 'pending',
    subtotal DECIMAL(10, 2),
    tax DECIMAL(10, 2),
    total DECIMAL(10, 2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Order Items Table
```sql
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache with mod_rewrite or PHP built-in server)

### Quick Start

1. **Navigate to project directory**
   ```bash
   cd /home/rehabwaleed/PHP/PHP_Project
   ```

2. **Configure Database**
   - Edit `config/dp.php`
   - Update database credentials:
   ```php
   private $host = 'localhost';
   private $dbname = 'PHP_Project';
   private $user = 'root';
   private $password = '';  // Your MySQL password
   ```

3. **Create Database Tables**
   - Execute the SQL schema (see Database Schema section above)
   - Or import database dump file if provided

4. **Set Permissions**
   ```bash
   chmod 755 uploads/
   ```

5. **Start Development Server**
   ```bash
   php -S localhost:8000
   ```

6. **Access Application**
   - Open browser: `http://localhost:8000`

### Default Credentials

**Admin Account**
- Email: `admin@test.com`
- Password: `admin123`
- Role: Admin

**Test User Account**
- Email: `user@test.com`
- Password: `user123`
- Role: User

## 📡 API Endpoints

### Authentication Routes
- `GET /login` - Login form page
- `POST /login` - Process user login
- `GET /register` - Registration form page
- `POST /register` - Process user registration
- `GET /logout` - Logout and destroy session

### Products API
- `GET /api/products` - Get all products (JSON)
- `GET /api/products/{id}` - Get product details
- `POST /api/products` - Create new product (admin)
- `PUT /api/products/{id}` - Update product (admin)
- `DELETE /api/products/{id}` - Delete product (admin)

### Orders API
- `GET /api/orders` - Get current user's orders
- `GET /api/orders/all` - Get all orders (admin)
- `GET /api/orders/{id}` - Get order details with items
- `POST /api/orders/create` - Create new order with items
- `POST /api/orders/{id}/status` - Update order status (admin)
- `POST /api/orders/{id}/cancel` - Cancel order

### Users API
- `GET /api/users` - Get all users (admin)
- `GET /api/users/{id}` - Get user details
- `GET /api/users/profile/me` - Get current user profile
- `POST /api/users` - Create new user (admin)
- `PUT /api/users/{id}` - Update user information
- `DELETE /api/users/{id}` - Delete user (admin)
- `GET /api/users/search/q?q=query` - Search users (admin)

### Web Routes
- `GET /` - Home/dashboard page
- `GET /products` or `/my_order` - Product browsing and menu
- `GET /orders` - User's order history
- `POST /order/create` - Create new order
- `GET /admin/products` - Admin product management (admin)
- `GET /admin/users` - Admin user management (admin)
- `GET /admin/orders` - Admin order management (admin)

### Response Format
All JSON API responses follow this format:
```json
{
  "success": true|false,
  "data": { /* response data */ },
  "message": "Optional message",
  "code": 200
}
```

## 🔐 Authentication & Authorization

### Session-Based Authentication
- User credentials verified against database
- Passwords hashed using PHP's `password_hash()`
- Session variables track `user_id` and `role`

### Role-Based Access Control
- **User**: Can browse products, create orders, view own orders
- **Admin**: Can manage all products, users, and orders
- Protected routes enforce role checking

## 💾 Database Models

### Service Pattern
All models inherit from `Service` class which provides:
- PDO database connection
- Connection pooling
- Transaction support

### Base Model Class
Common CRUD methods:
- `getAll()` - Fetch all records
- `getById($id)` - Get single record
- `findBy($column, $value)` - Find records by column
- `findOneBy($column, $value)` - Find first matching record
- `insert($data)` - Create new record
- `update($id, $data)` - Update record
- `delete($id)` - Delete record
- `query($sql, $params)` - Execute custom query with parameterized values

## 🛣️ Routing System

### Router Class Features
- RESTful routing with GET, POST, PUT, DELETE methods
- URL parameter extraction with regex patterns (e.g., `/users/{id}`)
- Flexible callback support (closures, controller methods)
- "Controller@method" string format for automatic dispatching
- 404 handling with custom response

### Example Routes
```php
// GET route
$router->get('/products/{id}', 'product@show');

// POST route
$router->post('/api/orders', 'order@store');

// Closure callback
$router->get('/', function() {
    include 'views/home.php';
});
```

## 🎨 Frontend Technology

- **HTML5**: Semantic markup
- **CSS3**: Modern gradient designs and flexbox layouts
- **JavaScript**: Async product loading, AJAX form submissions, client-side validation
- **Responsive Design**: Mobile-friendly layouts

## 🔒 Security Features

- **SQL Injection Prevention**: Parameterized queries throughout
- **Password Security**: bcrypt password hashing
- **Session Protection**: Server-side session management
- **CSRF Protection**: Form validation and method checking
- **Input Validation**: Server-side validation on all endpoints
- **Output Escaping**: HTML special character escaping with `htmlspecialchars()`

## � Security & Authentication

### Session-Based Authentication
- User credentials verified against hashed passwords in database
- Passwords secured with bcrypt (`password_hash()` with cost 12)
- Session variables: `user_id`, `email`, `name`, `role`
- Secure logout clears all session data

### Role-Based Access Control (RBAC)
- **User Role**: Browse products, create orders, view own orders, manage profile
- **Admin Role**: Manage all products, users, and orders system-wide
- Protected routes check role and redirect unauthorized access
- Admin middleware ensures only admins access admin routes

### Security Features Implemented
- SQL Injection Prevention: Parameterized queries with PDO prepared statements
- Password Security: bcrypt hashing with configurable cost
- CSRF Protection: Session validation and HTTP method checking
- Input Validation: Server-side validation on all endpoints
- Output Escaping: `htmlspecialchars()` on all user-generated content
- Session Security: Regenerate session ID after successful login
- Database Abstraction: PDO prevents direct SQL exposure

## 💾 Database Models & ORM Pattern

### Service Pattern (Database Connection)
Base `Service` class in `config/dp.php`:
```php
class Service {
    protected PDO $pdo;
    
    public function __construct() {
        // Singleton connection pattern
        // Reuses single database connection across requests
    }
}
```

### Model Classes (Data Access Layer)
Extend Service class, provide CRUD operations:
- **User Model**: User authentication, profile management
- **Product Model**: Product catalog, category management
- **Order Model**: Order processing, calculations, status tracking
- **OrderItem Model**: Individual order line items
- **Category Model**: Product categories and organization

### Common Model Methods
```php
$model->getAll();                    // Get all records
$model->getById($id);                // Get single record by ID
$model->findBy($column, $value);     // Find records matching criteria
$model->findOneBy($column, $value);  // Get first matching record
$model->insert($data);               // Create new record
$model->update($id, $data);          // Update existing record
$model->delete($id);                 // Delete record
$model->query($sql, $params);        // Execute custom parameterized query
```

## 🛣️ Routing System

### Router Class (`core/Router.php`)
Handles URL routing and request dispatching:

**Features**
- RESTful routing: GET, POST, PUT, DELETE methods
- URL parameters: `/orders/{id}` extracts id from URL
- Flexible callbacks: Closures, static methods, or `Controller@method` format
- Automatic controller instantiation and method dispatch
- 404 error handling with JSON responses
- Middleware support for before/after hooks

**Route Definition Examples**
```php
// Web routes (include view)
$router->get('/', function() { include 'views/user/home.php'; });

// Controller routes
$router->get('/products', 'productController@index');
$router->get('/orders/{id}', 'orderController@show');

// API routes
$router->post('/api/orders/create', 'orderController@create');
$router->put('/api/products/{id}', 'productController@update');
$router->delete('/api/products/{id}', 'productController@destroy');
```

## 📱 Responsive Design Features

### Mobile-First CSS
Base styles target mobile (320px+), then enhanced for larger screens:
- Tablet breakpoint: 768px
- Desktop breakpoint: 1024px+
- Large desktop: 1440px+

### Responsive Components
- **Navbar**: Hamburger menu on mobile, full navigation on desktop
- **Forms**: Full-width on mobile, optimized width on desktop
- **Cards**: Stacked single-column on mobile, grid layout on desktop
- **Tables**: Horizontal scroll on mobile, full display on desktop
- **Images**: Responsive sizes with max-width: 100%

### Responsive Utilities (CSS)
```css
@media (max-width: 768px) {
  .page-header h1 { font-size: 1.5rem; }
  .container { padding: 1rem; }
  .col-lg-7 { flex: 0 0 100%; }
}
```

## 🔒 Security Best Practices

### Database Security
1. **Parameterized Queries** (Prepared Statements)
   ```php
   $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->execute([$email]);  // Safe from SQL injection
   ```

2. **Connection Security**
   - Use PDO with error mode set to exceptions
   - Never concatenate user input into SQL
   - Always validate and sanitize input

### Authentication Security
1. **Password Hashing**
   ```php
   // Store hash
   $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
   
   // Verify
   if (password_verify($password, $hash)) { /* valid */ }
   ```

2. **Session Management**
   ```php
   session_start();
   session_regenerate_id(true);  // After login
   session_destroy();             // After logout
   ```

3. **Input Validation**
   ```php
   // Email validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       throw new Exception("Invalid email");
   }
   ```

### Output Security
1. **HTML Escaping** (XSS Prevention)
   ```php
   echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
   ```

2. **JSON Output** (API Responses)
   ```php
   header('Content-Type: application/json');
   echo json_encode(['success' => true, 'data' => $data]);
   ```

### File Upload Security
- Validate file type by MIME
- Store uploads outside web root if possible
- Rename files to prevent direct execution
- Set proper permissions (644 for files, 755 for directories)

## 📝 Usage & Common Tasks

### User Registration & Login
```
1. Navigate to /register
2. Enter: Name, Email, Password, Room #, Ext, Building
3. Submit form
4. Login at /login with email and password
5. Session established, redirected to home
```

### Create an Order
```
1. Login to user account
2. Go to /products (or /my_order)
3. Browse cafeteria items
4. Click "Add to Order" on items
5. Set quantities for each item
6. Click "Proceed to Checkout"
7. Review order summary (shows subtotal + 14% tax)
8. Confirm order
9. Order saved with status "pending"
10. View in /orders with filtering options
```

### Admin: Manage Orders
```
1. Login as admin account (admin@test.com / admin123)
2. Navigate to /admin/orders
3. View all system orders
4. Update order status:
   - pending → processing → out-for-delivery → done
5. Cancel orders if needed
6. View detailed order items and calculations
```

### Admin: Manage Products
```
1. Go to /admin/products
2. Add Product:
   - Fill name, price, category, description
   - Upload product image
   - Click "Add Product"
3. Edit Product:
   - Click edit icon on product row
   - Modify details
   - Save changes
4. Delete Product:
   - Click delete icon
   - Confirm deletion
```

### Admin: Manage Users
```
1. Go to /admin/users
2. Add User:
   - Fill all fields (name, email, password, room, ext, building)
   - Select role (user or admin)
   - Click "Add User"
3. Edit User:
   - Click edit icon
   - Update information
   - Save changes
4. Delete User:
   - Click delete icon
   - Confirm deletion
```

## 🐛 Troubleshooting Guide

### Database Connection Error
**Error**: `SQLSTATE[HY000]: General error`
**Solution**:
```bash
# Check MySQL service is running
sudo systemctl status mysql

# Verify credentials in config/dp.php
# Create database if not exists
mysql -u root -p -e "CREATE DATABASE PHP_Project;"
```

### Image Upload Issues
**Error**: Image not uploading or displaying
**Solution**:
```bash
# Set correct permissions
chmod 755 /home/rehabwaleed/PHP/PHP_Project/uploads/

# Check file permissions
ls -la uploads/

# Verify PHP upload settings in php.ini
# upload_max_filesize and post_max_size
```

### Session/Login Problems
**Error**: Cannot login or session expires immediately
**Solution**:
- Clear browser cookies (Ctrl+Shift+Del)
- Verify email format is valid
- Check password is at least 6 characters
- Ensure PHP session directory has write permissions
- Check session.save_path in php.ini

### Styling Not Showing (Dark Theme Missing)
**Error**: Page appears unstyled or with wrong colors
**Solution**:
```bash
# Check CSS file link in page head
# Verify modern.css exists
ls -la css/modern.css

# Clear browser cache (Ctrl+Shift+R)
# Check browser console for 404 errors
```

### 404 Routes Not Working
**Error**: Page not found, 404 error
**Solution**:
- Verify route is defined in index.php
- Check Router.php handles the HTTP method (GET/POST)
- Ensure parameters match route pattern
- Check URL formatting in links

## 📚 Development Guidelines

### Code Organization
- **Models** (`models/`): Data access and business logic
- **Controllers** (`controllers/`): Handle requests, orchestrate models
- **Views** (`views/`): Display templates using modern.css
- **Core** (`core/`): Framework classes (Router, Model base class)
- **Config** (`config/`): Configuration and Service class

### Naming Conventions
- Controllers: PascalCase ending in "Controller" (e.g., `productController`)
- Models: lowercase singular (e.g., `products.php`)
- Views: lowercase with underscores (e.g., `user/home.php`)
- CSS Classes: kebab-case (e.g., `.card-modern`, `.btn-primary`)
- Variables: camelCase (e.g., `$userName`, `$totalPrice`)
- Constants: UPPER_CASE (e.g., `TAX_RATE = 0.14`)

### File Permissions
```bash
# Directories
find . -type d -exec chmod 755 {} \;

# Files
find . -type f -exec chmod 644 {} \;

# Uploads directory (writable)
chmod 755 uploads/
```

### Performance Optimization Tips
1. **Database**: Add indexes to frequently queried columns
2. **CSS**: Use CSS variables for theme switching (no file regeneration)
3. **Images**: Optimize image sizes before upload
4. **Caching**: Cache database query results for read-heavy operations
5. **Minification**: Minify CSS/JS in production (use CDN versions)

## 🚀 Deployment Checklist

Before deploying to production:
- [ ] Set `error_reporting = 0` and `display_errors = off`
- [ ] Enable error logging to file
- [ ] Set proper file permissions (644/755)
- [ ] Use HTTPS only
- [ ] Set secure session cookies
- [ ] Keep database credentials in `.env` file
- [ ] Enable database query logging for debugging
- [ ] Set up automated backups
- [ ] Configure firewall and fail2ban
- [ ] Set up monitoring and alerts

## 🔄 Project Refactoring Summary

**Phase 1: Design Modernization**
- Applied premium dark theme with coffee-colored accents
- Updated all pages with modern styling and gradients

**Phase 2: Unified Design System**
- Created `css/modern.css` with 30+ reusable component classes
- Centralized color management with CSS variables
- Eliminated inline style duplication

**Phase 3: Component Architecture**
- Created reusable navbar component (`views/components/navbar.php`)
- Standardized card, form, and button styling
- Implemented consistent responsive design

**Phase 4: Code Cleanup**
- Removed 5 old/duplicate view files
- Deleted 9 redundant documentation files
- Cleaned up unused template files
- Organized project structure for maintainability

**Current Status**: Production-ready with modern dark theme, optimized codebase, and professional UI/UX

## 📄 License & Information

**Project Type**: Educational Full-Stack PHP Web Application
**Architecture**: Custom MVC Framework
**Technologies**: PHP 7.4+, MySQL 5.7+, Bootstrap 5.3.0, Font Awesome 6.4.0
**Status**: ✅ Production Ready
**Version**: 2.0.0 (Modern Dark Theme)

---

**Last Updated**: March 16, 2026
**Current Build**: Fully Modernized
**Maintainer**: Development Team

For questions or issues, refer to the troubleshooting section or review code comments in relevant files.
