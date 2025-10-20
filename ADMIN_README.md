# Larablog Admin Dashboard - Deployment Guide

## Overview
This Laravel application features a modern admin dashboard built with Bootstrap 5, inspired by the Console Lite template. It includes user management, post management, and dynamic data visualization.

## Features
- **Modern Admin Dashboard**: Clean, responsive interface with Bootstrap 5
- **User Management**: View, manage, and delete users
- **Post Management**: Comprehensive blog post administration
- **Dynamic Charts**: Interactive data visualization with Chart.js
- **Role-Based Access**: Admin middleware for secure access
- **Mobile Responsive**: Optimized for all devices

## System Requirements
- PHP >= 7.1.3 (recommended: PHP 8.0+)
- MySQL/MariaDB or PostgreSQL
- Composer
- Node.js & NPM (for asset compilation)
- Apache/Nginx web server

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/ZeeNthakheni/Larablog.git
cd Larablog
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larablog
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
# Create database tables
php artisan migrate

# Seed database with admin user and sample data
php artisan db:seed
```

### 6. Storage Setup
```bash
# Create storage symlink for file uploads
php artisan storage:link

# Set permissions (Linux/macOS)
chmod -R 775 storage bootstrap/cache
```

### 7. Asset Compilation
```bash
# Compile assets for production
npm run production

# Or for development
npm run dev
```

### 8. Web Server Configuration

#### Apache (.htaccess)
Ensure mod_rewrite is enabled. The .htaccess file should handle URL rewriting.

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/larablog/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Default Admin Credentials

After running the seeders, use these credentials to access the admin dashboard:

**Admin User:**
- Email: `admin@larablog.com`
- Password: `admin123`

**Test User:**
- Email: `john@example.com`
- Password: `password123`

## Admin Dashboard Access

1. Navigate to `/login` to access the login page
2. Use admin credentials to log in
3. Access admin dashboard at `/admin`

## Admin Features

### Dashboard Overview
- **Statistics Cards**: Total users, posts, active users, recent posts
- **Interactive Charts**: Monthly statistics and content distribution
- **Recent Activity**: Latest posts and users

### User Management (`/admin/users`)
- View all registered users
- User details with post count and activity
- Delete users (except admins and self)
- Pagination support

### Post Management (`/admin/posts`)
- View all blog posts
- Edit and delete posts
- View post authors
- Quick access to public post view

## Security Features

### Admin Middleware
- Role-based access control
- Protects admin routes from unauthorized access
- Redirects non-admin users with 403 error

### Authentication
- Secure login system
- Password hashing
- Remember me functionality
- CSRF protection

## Customization

### Styling
The admin dashboard uses custom CSS variables for easy theming:
```css
:root {
    --bs-sidebar-width: 280px;
    --bs-sidebar-bg: #212529;
    --bs-sidebar-color: rgba(255, 255, 255, 0.75);
}
```

### Adding New Admin Features
1. Create new controller methods in `AdminController`
2. Add routes to the admin group in `routes/web.php`
3. Create corresponding Blade templates in `resources/views/admin/`

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Test Coverage
- Admin dashboard access control
- User management functionality
- Authentication system
- Model relationships

## Production Deployment

### 1. Environment Optimization
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 2. Security Considerations
- Set `APP_DEBUG=false` in production
- Use HTTPS for all admin access
- Set strong `APP_KEY`
- Configure proper file permissions
- Regular security updates

### 3. Performance Optimization
- Enable OPcache
- Use Redis for caching
- Configure CDN for assets
- Optimize database queries

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

2. **Route Not Found**
   ```bash
   php artisan route:clear
   php artisan config:clear
   ```

3. **Database Connection**
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check firewall settings

### Log Files
- Application logs: `storage/logs/laravel.log`
- Web server logs: Check Apache/Nginx error logs

## Support

For technical support or feature requests:
1. Check the GitHub issues page
2. Review Laravel documentation
3. Contact the development team

## License
This project is open-sourced software licensed under the MIT license.