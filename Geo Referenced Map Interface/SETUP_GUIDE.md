# Step-by-Step Setup Guide

Complete setup instructions for the Geo Referenced Map Interface project on Windows.

## 📋 Prerequisites Check

Before starting, verify you have these installed:

### Check PHP Version

```bash
php -v
```

You should see PHP 8.2 or higher. Example output:

```
PHP 8.2.12 (cli) (built: Oct 17 2023 12:31:23) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.12, Copyright (c) Zend Technologies
```

### Check Composer Version

```bash
composer -v
```

You should see Composer 2.x. Example output:

```
Composer version 2.9.5 2024-01-15 13:09:28
```

### Check MySQL Version (via Command Line or MySQL Workbench)

```bash
mysql -u root -p -e "SELECT VERSION();"
```

You should see MySQL 8.0+

If any of these are not installed, follow the installation guides in the [Prerequisites](#prerequisites) section.

---

## Prerequisites

### 1. Install PHP 8.2+

**Option A: Using XAMPP (Recommended for Windows)**

1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP with PHP 8.2+
3. Verify installation: `php -v`

**Option B: Using WordPress Hosting Provider**
Skip to next step if already have PHP hosting.

### 2. Install Composer

1. Download from https://getcomposer.org/download/
2. Run the Windows Installer
3. Choose your PHP installation path when prompted
4. Verify: `composer -v`

### 3. Install MySQL

**Option A: Using XAMPP**

- Already included if you installed XAMPP above

**Option B: Download Separately**

1. Download from https://dev.mysql.com/downloads/mysql/
2. Run installer and follow setup wizard
3. Set root password (remember this!)

**Option C: Using MySQL Workbench**

- Download from https://dev.mysql.com/downloads/workbench/

### 4. Install Git (Optional but Recommended)

1. Download from https://git-scm.com/
2. Run installer with default settings
3. Verify: `git --version`

---

## Installation Steps

### Step 1: Prepare Your Environment

**Start XAMPP (if using):**

- Open XAMPP Control Panel
- Click "Start" for Apache and MySQL

**Verify all services:**

```bash
php -v
composer -v
mysql -u root -p -e "SELECT 1;"
```

---

### Step 2: Extract/Clone Project

**Option A: Extract ZIP File**

```bash
# Navigate to Desktop or your preferred location
cd Desktop

# Extract the project folder
# (Right-click → Extract All, or use this command)
```

**Option B: Clone from Git**

```bash
cd Desktop
git clone <repository-url> "Geo Referenced Map Interface"
cd "Geo Referenced Map Interface"
```

---

### Step 3: Navigate to Project Directory

```bash
cd Desktop
cd "Location Finder System"
cd "Geo Referenced Map Interface"

# Verify you're in the right location
dir  # You should see: app, resources, routes, database, .env, etc.
```

---

### Step 4: Install Dependencies

```bash
# Install all PHP dependencies using Composer
composer install

# Wait for installation to complete (5-15 minutes depending on internet speed)
# You should see no errors at the end
```

**If you encounter errors:**

```bash
# Try with this command instead
composer install --no-scripts
```

---

### Step 5: Configure Environment File

**Copy environment template:**

```bash
copy .env.example .env
```

**OR manually:**

1. Copy `.env.example` file
2. Paste and rename to `.env` in the same directory
3. Edit `.env` file with your settings

**Open `.env` in a text editor and update these values:**

```env
APP_NAME="Geo Referenced Map Interface"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geo_map_interface
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

MAIL_MAILER=log
```

---

### Step 6: Generate Application Key

```bash
php artisan key:generate
```

Expected output:

```
Application key [base64:...] set successfully.
```

---

### Step 7: Create Database

**Option A: Using MySQL Command Line**

```bash
# Open MySQL command prompt
mysql -u root -p

# In MySQL console, run:
CREATE DATABASE geo_map_interface;
EXIT;
```

**Option B: Using MySQL Workbench**

1. Open MySQL Workbench
2. Connect to local MySQL server
3. Right-click → Create New Schema
4. Name it: `geo_map_interface`
5. Apply changes

**Option C: Using phpMyAdmin (via XAMPP)**

1. Open http://localhost/phpmyadmin
2. Click "New" on the left sidebar
3. Enter database name: `geo_map_interface`
4. Click "Create"

---

### Step 8: Run Database Migrations

```bash
# Create all tables in the database
php artisan migrate

# You should see output like:
# Migrating: 2024_01_01_000001_create_categories_table
# Migrated: 2024_01_01_000001_create_categories_table (xxx ms)
# Migrating: 2024_01_01_000002_create_locations_table
# Migrated: 2024_01_01_000002_create_locations_table (xxx ms)
```

---

### Step 9: Seed the Database

```bash
# Populate database with sample data
php artisan db:seed

# You should see output like:
# Database seeding completed successfully.
```

This creates:

- 10 default categories (Hospital, School, etc.)
- 4 sample locations
- 1 test user account: `user@example.com` / `password`

---

### Step 10: Setup API Authentication (Sanctum)

```bash
# Install Laravel Sanctum for API authentication
php artisan install:api

# Accept prompts by typing 'yes' or pressing Enter
```

---

### Step 11: Create Storage Symbolic Link

```bash
# Create link for file uploads
php artisan storage:link

# Expected output:
# The [public/storage] directory has been linked.
```

---

### Step 12: Start Development Server

```bash
# Start Laravel development server
php artisan serve

# You should see:
# Laravel development server started: http://127.0.0.1:8000
```

**Leave this terminal window open.** Open a new terminal/command prompt for other commands.

---

## Accessing the Application

### Access in Browser

Open your web browser and go to:

```
http://localhost:8000
```

You should see the home page with the map interface.

---

## First Time Login

### Create New Account

1. Click "Register" or "Sign In" → "Register"
2. Enter details:
    - **Name:** Your name
    - **Email:** Your email address
    - **Password:** Your password (min 8 characters)
    - **Confirm Password:** Repeat password
3. Click "Register"
4. You're automatically logged in!

### OR Login with Test Account

1. Click "Login"
2. Enter credentials:
    - **Email:** `user@example.com`
    - **Password:** `password`
3. Click "Login"

---

## Verify Installation

### Test These Features

**1. Dashboard**

- Click "Dashboard" in navigation
- You should see location statistics
- See "Recent Locations" section

**2. Add Location**

- Click "Add Location"
- Fill in: Name, Description, Category, Coordinates
- Click on map to set coordinates
- Click "Save Location"

**3. View Map**

- Click "Interactive Map"
- You should see locations as markers
- Click markers to see information
- Use search/filter to find locations

**4. API Test**
In a new terminal (keep server running):

```bash
curl -X GET "http://localhost:8000/api/health"
```

Expected response:

```json
{ "status": "ok", "message": "...API is running" }
```

---

## Common Issues & Solutions

### Issue: "Connection refused" when accessing localhost:8000

**Solution:**

```bash
# Make sure server is running
php artisan serve

# Output should show: "Server running on [http://127.0.0.1:8000]"
```

### Issue: Database connection error

**Check .env file:**

- DB_HOST = 127.0.0.1
- DB_PORT = 3306 (default)
- DB_USERNAME = root
- DB_PASSWORD = your password
- DB_DATABASE = geo_map_interface

**Restart MySQL:**

```bash
# In XAMPP, stop and start MySQL
# Or from command line:
mysql -u root -p -e "SELECT 1;"
```

### Issue: "No application encryption key has been specified"

**Solution:**

```bash
php artisan key:generate
```

### Issue: "Table not found" error

**Solution:**

```bash
# Run migrations
php artisan migrate

# Then seed data
php artisan db:seed
```

### Issue: File upload not working

**Solution:**

```bash
# Create storage link
php artisan storage:link
```

### Issue: Map not displaying

**Solution:**

1. Check browser console (F12) for errors
2. Ensure internet connection (for OpenStreetMap tiles)
3. Verify Leaflet CDN is accessible
4. Check latitude/longitude values are valid

### Issue: Composer install fails

**Solution:**

```bash
# Clear composer cache
composer clear-cache

# Try installation again
composer install --no-scripts
```

---

## Project Structure Tour

```
project/
├── app/
│   ├── Http/Controllers/
│   │   ├── LocationController.php        ← Edit/create locations
│   │   ├── MapController.php             ← Map functionality
│   │   └── Api/LocationApiController.php ← API endpoints
│   └── Models/
│       ├── Location.php                  ← Location model
│       └── Category.php                  ← Category model
├── database/
│   ├── migrations/                       ← Table schemas
│   └── seeders/                          ← Sample data
├── resources/views/
│   ├── locations/                        ← Location forms and lists
│   └── map/                              ← Map view
├── routes/
│   ├── web.php                           ← Web routes
│   └── api.php                           ← API routes
└── .env                                  ← Configuration file
```

---

## Development Workflow

### Making Changes

1. **Edit a Blade template:**
    - Navigate to `resources/views/`
    - Edit `.blade.php` files
    - Refresh browser to see changes

2. **Edit a Controller:**
    - Navigate to `app/Http/Controllers/`
    - Edit controller files
    - Refresh browser to see changes

3. **Edit a Model:**
    - Navigate to `app/Models/`
    - Edit model files
    - May need to restart server

### Testing Changes

**Without restarting server:**

- View files (Blade templates)
- Static assets (CSS, images)

**May need restart:**

- Controller logic
- Model changes
- New routes

**Always restart after:**

- Database changes
- Dependency installations

---

## Language Switching

### Change Language

In the navigation bar:

1. Click language selector (top right)
2. Choose "English" or "हिंदी"
3. Page content updates instantly

### Translation Files Location

- English: `resources/lang/en/messages.php`
- Hindi: `resources/lang/hi/messages.php`

---

## Database Management

### View Database

**Using phpMyAdmin (XAMPP):**

1. Go to http://localhost/phpmyadmin
2. Click `geo_map_interface` database
3. Browse tables

**Using MySQL Workbench:**

1. Connect to local server
2. Select `geo_map_interface`
3. View tables and data

### Reset Database

```bash
# Delete all data and reset tables
php artisan migrate:fresh

# Reset tables and seed sample data
php artisan migrate:fresh --seed
```

### Backup Database

```bash
# Export database to SQL file
mysqldump -u root -p geo_map_interface > backup.sql
```

---

## API Usage Quick Reference

### Get API Token

After login, generate token from dashboard or use curl:

```bash
# Login and get session
curl -X POST http://localhost:8000/login \
  -d "email=user@example.com&password=password" \
  -c cookies.txt

# Get API resources
curl -X GET http://localhost:8000/api/locations \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Test API Endpoints

```bash
# Health check (no auth needed)
curl http://localhost:8000/api/health

# Get all locations (requires token)
curl -H "Authorization: Bearer YOUR_TOKEN" \
  http://localhost:8000/api/locations

# Create location
curl -X POST http://localhost:8000/api/locations \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"location_name":"Test","latitude":28.7041,"longitude":77.1025,"category_id":1}'
```

For detailed API documentation, see [API_GUIDE.md](API_GUIDE.md)

---

## Stopping the Development Server

Press `Ctrl+C` in the terminal running `php artisan serve`

---

## Next Steps

1. ✅ Explore the application
2. ✅ Add your own locations
3. ✅ Test API endpoints
4. ✅ Customize styling in `resources/views/layouts/app.blade.php`
5. ✅ Add more features as needed
6. ✅ Deploy to production (see Production Setup)

---

## Production Deployment

For production deployment, refer to:

- Laravel: https://laravel.com/docs/deployment
- Environment: Set `APP_DEBUG=false` in `.env`
- Database: Use managed database service
- Files: Use CDN or cloud storage for images

---

## Support & Resources

- **Laravel Docs:** https://laravel.com/docs
- **Blade Guide:** https://laravel.com/docs/blade
- **Leaflet.js:** https://leafletjs.com/
- **OpenStreetMap:** https://www.openstreetmap.org/

---

**You're ready to go! Happy coding! 🚀**
