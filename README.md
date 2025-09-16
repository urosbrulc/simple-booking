# Car Booking System

A Laravel 12 web application for car rental management with user authentication, car booking functionality, and admin panel.

Test URL: https://diploma.urosbrulc.com/public/

## Features

### User Features
- User registration and login
- Search for available cars by date range
- Book cars for specific date ranges
- View personal booking history
- Cancel bookings (if not yet started)

### Admin Features
- Admin dashboard with statistics
- Manage cars (create, edit, delete, view)
- View all bookings and revenue
- Role-based access control

## Requirements

- PHP 8.2+
- MySQL 5.7+
- Composer
- Node.js & NPM (for frontend assets)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd car-booking-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=car_booking
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

### Admin Account
- **Email:** info@urosbrulc.com
- **Password:** penko120
- **Role:** Admin

### Regular User Account
- **Email:** user@example.com
- **Password:** password
- **Role:** User

## Database Structure

### Tables
- `users` - User accounts with role-based access
- `cars` - Car inventory management
- `bookings` - Car booking records
- `sessions` - User session management
- `cache` - Application caching
- `jobs` - Queue job management

### Key Relationships
- Users have many Bookings
- Cars have many Bookings
- Bookings belong to Users and Cars

## API Endpoints

### Public Routes
- `GET /` - Home page
- `GET /login` - Login form
- `POST /login` - Login submission
- `GET /register` - Registration form
- `POST /register` - Registration submission

### User Routes (Authenticated)
- `GET /bookings` - My bookings
- `GET /bookings/search` - Search cars
- `GET /bookings/create` - Create booking form
- `POST /bookings` - Store booking
- `DELETE /bookings/{booking}` - Cancel booking

### Admin Routes (Admin role required)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/cars` - Car management
- `POST /admin/cars` - Create car
- `GET /admin/cars/{car}` - View car details
- `PUT /admin/cars/{car}` - Update car
- `DELETE /admin/cars/{car}` - Delete car

## Design Decisions

### Architecture
- **MVC Pattern:** Clean separation of concerns with Models, Views, and Controllers
- **Middleware:** Role-based access control using custom AdminMiddleware
- **Eloquent ORM:** Database relationships and query optimization
- **Blade Templates:** Server-side rendering with Bootstrap 5 styling

### Security
- **CSRF Protection:** All forms include CSRF tokens
- **Role-based Access:** Admin routes protected by middleware
- **Input Validation:** Server-side validation for all user inputs
- **SQL Injection Prevention:** Using Eloquent ORM and prepared statements

### User Experience
- **Responsive Design:** Bootstrap 5 for mobile-friendly interface
- **Real-time Feedback:** Success/error messages for user actions
- **Date Validation:** Prevents booking cars for past dates
- **Availability Checking:** Prevents double-booking of cars

### Performance
- **Pagination:** Large datasets paginated for better performance
- **Eager Loading:** Relationships loaded efficiently to prevent N+1 queries
- **Indexing:** Database indexes on frequently queried columns

## Testing

Run the test suite:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

