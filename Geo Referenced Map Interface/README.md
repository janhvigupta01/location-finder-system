# Geo Referenced Map Interface

A beginner-friendly Laravel MVC web application that displays geo-referenced locations on an interactive map using open-source technologies. Perfect for college mini projects or major project submissions.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📋 Table of Contents

1. [Features](#features)
2. [Tech Stack](#tech-stack)
3. [Project Structure](#project-structure)
4. [Installation](#installation)
5. [Database Setup](#database-setup)
6. [API Documentation](#api-documentation)
7. [Usage Guide](#usage-guide)
8. [Troubleshooting](#troubleshooting)

## ✨ Features

### Core Features

- ✅ User authentication with secure login/registration
- ✅ User dashboard with statistics and recent locations
- ✅ Interactive map powered by OpenStreetMap & Leaflet.js
- ✅ Full CRUD operations for locations (Create, Read, Update, Delete)
- ✅ Location categorization (Hospital, School, Restaurant, etc.)
- ✅ Image upload and storage for locations
- ✅ Search and filter functionality
- ✅ REST API with JSON responses
- ✅ Bilingual support (English & Hindi)
- ✅ Responsive Bootstrap-based UI
- ✅ Mobile-friendly design

### Database Features

- Users table with authentication
- Locations table with geo-coordinates
- Categories table for location organization
- Relationships and proper indexing

### Technical Highlights

- **MVC Architecture**: Proper separation of concerns
- **Eloquent ORM**: Database relationships and queries
- **Blade Templates**: Dynamic view rendering
- **Route Groups & Middleware**: Authentication and authorization
- **Form Validation**: Input validation with custom error messages
- **Session Management**: Flash messages and user sessions
- **API Routes**: RESTful endpoints with proper HTTP methods

## 🛠 Tech Stack

### Backend

- **PHP 8.2+**: Modern PHP version
- **Laravel 12**: Web framework
- **MySQL 8.0**: Database
- **Composer**: Dependency manager

### Frontend

- **HTML5 & CSS3**: Markup and styling
- **Bootstrap 5**: Responsive UI framework
- **Blade Templates**: Laravel templating engine
- **JavaScript**: Client-side interactivity
- **Leaflet.js**: Interactive mapping library
- **Font Awesome**: Icon library

### Mapping

- **OpenStreetMap**: Free mapping data
- **Leaflet.js**: Interactive map library

### Other

- **Sanctum**: API authentication tokens
- **Laravel Breeze**: Authentication scaffolding (optional)

## 📁 Project Structure

```
Geo Referenced Map Interface/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php           # Home & About pages
│   │   │   ├── DashboardController.php      # User dashboard
│   │   │   ├── LocationController.php       # Location CRUD
│   │   │   ├── MapController.php            # Map display
│   │   │   └── Api/
│   │   │       └── LocationApiController.php # REST API
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Location.php                    # Location model with relations
│   │   └── Category.php                    # Category model
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_categories_table.php
│   │   └── 2024_01_01_000002_create_locations_table.php
│   └── seeders/
│       ├── CategorySeeder.php              # Seed categories
│       ├── LocationSeeder.php              # Seed sample locations
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php               # Master layout
│   │   ├── home.blade.php
│   │   ├── about.blade.php
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   ├── locations/
│   │   │   ├── index.blade.php             # List locations
│   │   │   ├── create.blade.php            # Add location with map
│   │   │   ├── edit.blade.php              # Edit location
│   │   │   └── show.blade.php              # Location details
│   │   └── map/
│   │       └── index.blade.php             # Interactive map
│   └── lang/
│       ├── en/messages.php                 # English translations
│       └── hi/messages.php                 # Hindi translations
├── routes/
│   ├── web.php                             # Web routes
│   └── api.php                             # API routes
├── .env                                    # Environment configuration
├── .env.example
└── README.md

```

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Git (optional)

### Step 1: Clone or Download

```bash
# If downloaded as zip, extract it
# Or clone from git
git clone <repository-url>
cd "Geo Referenced Map Interface"
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

```bash
# Copy .env.example to .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geo_map_interface
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create database:

```bash
# In MySQL
CREATE DATABASE geo_map_interface;
```

### Step 5: Run Migrations and Seeds

```bash
# Run migrations to create tables
php artisan migrate

# Seed database with categories and sample data
php artisan db:seed
```

### Step 6: Generate Passport/Sanctum Key (for API)

```bash
php artisan install:api
```

### Step 7: Create Storage Link (for images)

```bash
php artisan storage:link
```

### Step 8: Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 💾 Database Setup

### Database Schema

#### Users Table (built-in)

```sql
CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

#### Categories Table

```sql
CREATE TABLE categories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  category_name VARCHAR(255) UNIQUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

#### Locations Table

```sql
CREATE TABLE locations (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT NOT NULL,
  category_id BIGINT,
  location_name VARCHAR(255),
  description TEXT,
  latitude DECIMAL(10, 8),
  longitude DECIMAL(11, 8),
  image VARCHAR(255),
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  FULLTEXT INDEX ft_search (location_name, description)
);
```

### Default Categories

- Hospital
- School
- Tourist Place
- Restaurant
- Office
- Park
- Library
- Museum
- Shopping Mall
- Other

## 📡 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Authentication

All API endpoints (except `/api/health`) require Bearer token authentication:

```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

### Endpoints

#### 1. Health Check (No Auth Required)

```http
GET /api/health
```

**Response:**

```json
{
    "status": "ok",
    "message": "Geo Referenced Map Interface API is running"
}
```

#### 2. Get All Locations

```http
GET /api/locations
```

**Parameters:**

- `per_page` (optional): Items per page (default: 10)
- `search` (optional): Search term
- `category_id` (optional): Filter by category

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "location_name": "City Hospital",
            "description": "Main city hospital",
            "latitude": 28.7041,
            "longitude": 77.1025,
            "category_id": 1,
            "user_id": 1,
            "image": "locations/image.jpg",
            "category": {
                "id": 1,
                "category_name": "Hospital"
            }
        }
    ],
    "pagination": {
        "total": 50,
        "per_page": 10,
        "current_page": 1,
        "last_page": 5
    }
}
```

#### 3. Get Single Location

```http
GET /api/locations/{id}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "location_name": "City Hospital",
        "description": "Main city hospital",
        "latitude": 28.7041,
        "longitude": 77.1025,
        "category": {
            "id": 1,
            "category_name": "Hospital"
        }
    }
}
```

#### 4. Create Location

```http
POST /api/locations
Content-Type: application/json
```

**Request Body:**

```json
{
    "location_name": "New Hospital",
    "description": "Hospital description",
    "latitude": 28.7041,
    "longitude": 77.1025,
    "category_id": 1
}
```

**Response:** (201 Created)

```json
{
  "success": true,
  "message": "Location created successfully",
  "data": {
    "id": 2,
    "location_name": "New Hospital",
    ...
  }
}
```

#### 5. Update Location

```http
PUT /api/locations/{id}
Content-Type: application/json
```

**Request Body:** (any or all fields)

```json
{
    "location_name": "Updated Name",
    "latitude": 28.7041,
    "longitude": 77.1025
}
```

#### 6. Delete Location

```http
DELETE /api/locations/{id}
```

**Response:**

```json
{
    "success": true,
    "message": "Location deleted successfully"
}
```

#### 7. Get All Categories

```http
GET /api/categories
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "category_name": "Hospital",
            "created_at": "2024-01-01T00:00:00Z",
            "updated_at": "2024-01-01T00:00:00Z"
        }
    ]
}
```

#### 8. Get Locations as GeoJSON

```http
GET /api/locations/geojson/all
```

**Response:**

```json
{
    "success": true,
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [77.1025, 28.7041]
            },
            "properties": {
                "id": 1,
                "name": "City Hospital",
                "description": "Main city hospital",
                "category": "Hospital",
                "image": "url/to/image.jpg"
            }
        }
    ]
}
```

### Error Responses

**404 Not Found:**

```json
{
    "success": false,
    "message": "Location not found"
}
```

**422 Validation Error:**

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "location_name": ["The location name field is required."],
        "latitude": ["The latitude must be between -90 and 90."]
    }
}
```

**401 Unauthorized:**

```json
{
    "message": "Unauthenticated."
}
```

## 📖 Usage Guide

### User Registration & Login

1. Go to `http://localhost:8000/register`
2. Create a new account with email and password
3. Confirm your email (if configured)
4. Login to dashboard

### Adding a Location

1. Click "Add Location" button
2. Fill in location details:
    - Location Name (required)
    - Description (optional)
    - Category (required)
    - Latitude & Longitude (required)
3. Option to click on map to set coordinates
4. Upload location image (optional)
5. Click "Save Location"

### Viewing Locations

**Dashboard:**

- See total locations count
- View recent locations
- Quick action buttons

**Locations List:**

- View all locations in table format
- Search by name
- Filter by category
- Pagination support

**Interactive Map:**

- View all locations on the map
- Click markers for information
- Search and filter locations
- Zoom and pan controls

### Managing Locations

- **Edit**: Click the edit button to modify location details
- **View**: Click location name to see full details
- **Delete**: Remove locations with delete button

### Language Switching

- Click language dropdown in navigation
- Select English or हिंदी
- Language preference saved in session

### Using the API

#### Example: Get locations using cURL

```bash
curl -X GET http://localhost:8000/api/locations \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

#### Example: Create location using Python

```python
import requests

headers = {
    'Authorization': 'Bearer YOUR_TOKEN_HERE',
    'Content-Type': 'application/json'
}

data = {
    'location_name': 'New Place',
    'description': 'A nice place',
    'latitude': 28.7041,
    'longitude': 77.1025,
    'category_id': 1
}

response = requests.post(
    'http://localhost:8000/api/locations',
    headers=headers,
    json=data
)

print(response.json())
```

## 🐛 Troubleshooting

### Database Connection Error

```
Error: SQLSTATE[HY000] [1045] Access denied
```

**Solution:** Check DB_USERNAME, DB_PASSWORD in `.env` file

### Storage Link Error

```
Error: symlink(/path/to/storage/app/public,...) failed
```

**Solution:** Run `php artisan storage:link`

### Key Generation Error

```
Error: No application encryption key has been specified
```

**Solution:** Run `php artisan key:generate`

### Missing Tables

```
Error: Table 'database.locations' doesn't exist
```

**Solution:** Run `php artisan migrate --seed`

### Image Upload Not Working

```
Error: Call to a member function store() on null
```

**Solution:** Ensure form has `enctype="multipart/form-data"`

### API Token Issues

```
Error: Unauthenticated
```

**Solution:**

1. Get token from login
2. Use `Authorization: Bearer TOKEN` header
3. Ensure token is valid and not expired

### Map Not Displaying

**Solution:**

1. Check browser console for errors
2. Ensure Leaflet and OpenStreetMap links are loaded
3. Verify coordinates are valid (lat: -90 to 90, lng: -180 to 180)

## 📝 Example Data

### Sample Locations with Coordinates

```
Delhi - 28.7041, 77.1025
Mumbai - 19.0760, 72.8777
Bangalore - 12.9716, 77.5946
Hyderabad - 17.3850, 78.4867
Pune - 18.5204, 73.8567
Chennai - 13.0827, 80.2707
Kolkata - 22.5726, 88.3639
Jaipur - 26.9124, 75.7873
```

## 📚 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Template Guide](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Routing](https://laravel.com/docs/routing)
- [Leaflet.js Documentation](https://leafletjs.com/)
- [OpenStreetMap](https://www.openstreetmap.org/)

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 👨‍💼 Support

For issues, feature requests, or questions:

1. Check the troubleshooting section
2. Review the documentation
3. Check Laravel/Leaflet documentation
4. Search existing issues

## 🎓 Educational Notes

This project demonstrates:

- **Laravel MVC Pattern**: Controllers, Models, Views
- **Database Design**: Relationships, migrations, seeders
- **Authentication**: Secure user management
- **REST APIs**: JSON responses, HTTP methods
- **Frontend Integration**: Maps, forms, validation
- **File Uploads**: Image storage and retrieval
- **Localization**: Multi-language support
- **Best Practices**: Clean code, comments, structure

Perfect for learning Laravel by building a real-world application!

---

**Happy Mapping! 🗺️**
