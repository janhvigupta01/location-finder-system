# API Documentation Guide

Complete API reference for the Geo Referenced Map Interface application.

## Quick Start

### Get API Token

First, you need to register and get an API token for authentication.

**1. Register a new account:**

```http
POST /register
Content-Type: application/x-www-form-urlencoded

name=John Doe&email=john@example.com&password=password123&password_confirmation=password123
```

**2. Get API Token:**

```http
POST /api/tokens/create (if using Sanctum)
OR login and generate token from dashboard
```

### Base Configuration

All API requests should include:

```
Base URL: http://localhost:8000/api
Header: Accept: application/json
Header: Authorization: Bearer YOUR_TOKEN_HERE
```

## API Endpoints

### 1. Health Check

**Status:** Public (No Authentication Required)

Check if the API is running and accessible.

```http
GET /api/health
```

**cURL Example:**

```bash
curl -X GET http://localhost:8000/api/health \
  -H "Accept: application/json"
```

**Response (200 OK):**

```json
{
    "status": "ok",
    "message": "Geo Referenced Map Interface API is running"
}
```

---

### 2. Get All Locations

**Status:** Authenticated Required

Retrieve paginated list of all locations.

```http
GET /api/locations
```

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| per_page | integer | Items per page (default: 10, max: 100) |
| page | integer | Page number (default: 1) |
| search | string | Search in location_name and description |
| category_id | integer | Filter by category ID |

**cURL Examples:**

Get first 10 locations:

```bash
curl -X GET "http://localhost:8000/api/locations" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

Search and filter:

```bash
curl -X GET "http://localhost:8000/api/locations?search=Hospital&category_id=1&per_page=5" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "location_name": "City Hospital",
            "description": "Main city hospital with modern facilities",
            "latitude": "28.70410000",
            "longitude": "77.10250000",
            "category_id": 1,
            "user_id": 1,
            "image": null,
            "category": {
                "id": 1,
                "category_name": "Hospital"
            },
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "location_name": "Central School",
            "description": "Government school",
            "latitude": "28.65000000",
            "longitude": "77.20000000",
            "category_id": 2,
            "user_id": 1,
            "image": "locations/school.jpg",
            "category": {
                "id": 2,
                "category_name": "School"
            },
            "created_at": "2024-01-02T00:00:00.000000Z",
            "updated_at": "2024-01-02T00:00:00.000000Z"
        }
    ],
    "pagination": {
        "total": 4,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1
    }
}
```

---

### 3. Get Single Location

**Status:** Authenticated Required

Retrieve details of a specific location.

```http
GET /api/locations/{id}
```

**Path Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| id | integer | Location ID |

**cURL Example:**

```bash
curl -X GET "http://localhost:8000/api/locations/1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "location_name": "City Hospital",
        "description": "Main city hospital with modern facilities",
        "latitude": "28.70410000",
        "longitude": "77.10250000",
        "category_id": 1,
        "user_id": 1,
        "image": null,
        "category": {
            "id": 1,
            "category_name": "Hospital"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

**Response (404 Not Found):**

```json
{
    "success": false,
    "message": "Location not found"
}
```

---

### 4. Create Location

**Status:** Authenticated Required

Create a new location.

```http
POST /api/locations
Content-Type: application/json
```

**Request Body:**

```json
{
    "location_name": "New Hospital",
    "description": "A modern hospital with advanced facilities",
    "latitude": 28.7041,
    "longitude": 77.1025,
    "category_id": 1
}
```

**Required Fields:**

- location_name (string, max 255)
- latitude (numeric, -90 to 90)
- longitude (numeric, -180 to 180)
- category_id (integer, must exist in categories)

**Optional Fields:**

- description (string)

**cURL Example:**

```bash
curl -X POST "http://localhost:8000/api/locations" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "location_name": "New Hospital",
    "description": "Modern hospital",
    "latitude": 28.7041,
    "longitude": 77.1025,
    "category_id": 1
  }'
```

**Python Example:**

```python
import requests
import json

url = "http://localhost:8000/api/locations"
headers = {
    "Authorization": "Bearer YOUR_TOKEN",
    "Content-Type": "application/json"
}
payload = {
    "location_name": "New Hospital",
    "description": "Modern hospital",
    "latitude": 28.7041,
    "longitude": 77.1025,
    "category_id": 1
}

response = requests.post(url, headers=headers, json=payload)
print(json.dumps(response.json(), indent=2))
```

**Response (201 Created):**

```json
{
    "success": true,
    "message": "Location created successfully",
    "data": {
        "id": 5,
        "location_name": "New Hospital",
        "description": "Modern hospital",
        "latitude": "28.70410000",
        "longitude": "77.10250000",
        "category_id": 1,
        "user_id": 1,
        "image": null,
        "category": {
            "id": 1,
            "category_name": "Hospital"
        },
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Response (422 Validation Error):**

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "location_name": ["The location name field is required."],
        "latitude": ["The latitude must be between -90 and 90."]
    }
}
```

---

### 5. Update Location

**Status:** Authenticated Required (Owner Only)

Update an existing location.

```http
PUT /api/locations/{id}
Content-Type: application/json
```

**Path Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| id | integer | Location ID |

**Request Body (all fields optional):**

```json
{
    "location_name": "Updated Hospital Name",
    "description": "Updated description",
    "latitude": 28.71,
    "longitude": 77.11,
    "category_id": 1
}
```

**cURL Example:**

```bash
curl -X PUT "http://localhost:8000/api/locations/1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "location_name": "Updated Hospital Name",
    "latitude": 28.7100,
    "longitude": 77.1100
  }'
```

**Response (200 OK):**

```json
{
    "success": true,
    "message": "Location updated successfully",
    "data": {
        "id": 1,
        "location_name": "Updated Hospital Name",
        "description": "Main city hospital with modern facilities",
        "latitude": "28.71000000",
        "longitude": "77.11000000",
        "category_id": 1,
        "user_id": 1,
        "image": null,
        "category": {
            "id": 1,
            "category_name": "Hospital"
        },
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-15T10:35:00.000000Z"
    }
}
```

---

### 6. Delete Location

**Status:** Authenticated Required (Owner Only)

Delete a location permanently.

```http
DELETE /api/locations/{id}
```

**Path Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| id | integer | Location ID |

**cURL Example:**

```bash
curl -X DELETE "http://localhost:8000/api/locations/1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**

```json
{
    "success": true,
    "message": "Location deleted successfully"
}
```

**Response (404 Not Found):**

```json
{
    "success": false,
    "message": "Location not found"
}
```

---

### 7. Get All Categories

**Status:** Authenticated Required

Retrieve all available location categories.

```http
GET /api/categories
```

**cURL Example:**

```bash
curl -X GET "http://localhost:8000/api/categories" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "category_name": "Hospital",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        {
            "id": 2,
            "category_name": "School",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        {
            "id": 3,
            "category_name": "Restaurant",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

---

### 8. Get Locations as GeoJSON

**Status:** Authenticated Required

Get all locations in GeoJSON format for map integration.

```http
GET /api/locations/geojson/all
```

**cURL Example:**

```bash
curl -X GET "http://localhost:8000/api/locations/geojson/all" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**

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
                "image_url": null
            }
        },
        {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [77.2, 28.65]
            },
            "properties": {
                "id": 2,
                "name": "Central School",
                "description": "Government school",
                "category": "School",
                "image_url": "http://localhost:8000/storage/locations/school.jpg"
            }
        }
    ]
}
```

---

## Error Handling

### Common Error Responses

**400 Bad Request:**

```json
{
    "message": "Invalid request format"
}
```

**401 Unauthorized:**

```json
{
    "message": "Unauthenticated."
}
```

**403 Forbidden:**

```json
{
    "message": "You are not authorized to perform this action"
}
```

**404 Not Found:**

```json
{
    "success": false,
    "message": "Resource not found"
}
```

**422 Unprocessable Entity:**

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

**500 Internal Server Error:**

```json
{
    "message": "Internal server error"
}
```

---

## Authentication Guide

### Using Sanctum Tokens

**1. Login and Get Token:**

```bash
# Using web form
curl -X POST http://localhost:8000/login \
  -d "email=user@example.com&password=password"
```

**2. Generate API Token (If using dashboard):**
Visit `/api-tokens` after logging in to generate a personal access token.

**3. Use Token in Requests:**

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  http://localhost:8000/api/locations
```

**4. Token Management:**

- Tokens are stored securely in the database
- Each token is associated with a user
- Use meaningful names for tokens to track their purpose
- Revoke tokens when no longer needed

---

## Rate Limiting

Currently, there is no rate limiting configured. For production deployment, consider implementing rate limiting:

```bash
# Example with Laravel throttle middleware
Route::middleware('throttle:60,1')->group(function () {
    Route::apiResource('locations', LocationApiController::class);
});
```

---

## Testing the API

### Postman Collection

Create a new Postman collection with these requests:

1. **Health Check** - GET `/api/health`
2. **Get All Locations** - GET `/api/locations`
3. **Create Location** - POST `/api/locations`
4. **Get Single Location** - GET `/api/locations/{id}`
5. **Update Location** - PUT `/api/locations/{id}`
6. **Delete Location** - DELETE `/api/locations/{id}`
7. **Get Categories** - GET `/api/categories`
8. **Get GeoJSON** - GET `/api/locations/geojson/all`

### JavaScript Fetch Examples

```javascript
// Get all locations
const response = await fetch("http://localhost:8000/api/locations", {
    method: "GET",
    headers: {
        Authorization: "Bearer YOUR_TOKEN",
        Accept: "application/json",
    },
});
const data = await response.json();
console.log(data);

// Create a location
const newLocation = await fetch("http://localhost:8000/api/locations", {
    method: "POST",
    headers: {
        Authorization: "Bearer YOUR_TOKEN",
        "Content-Type": "application/json",
        Accept: "application/json",
    },
    body: JSON.stringify({
        location_name: "New Place",
        latitude: 28.7041,
        longitude: 77.1025,
        category_id: 1,
    }),
});
const created = await newLocation.json();
console.log(created);
```

---

## Integration Examples

### Integrate Map with GeoJSON

```javascript
// Fetch locations and add to map
fetch("http://localhost:8000/api/locations/geojson/all", {
    headers: { Authorization: "Bearer YOUR_TOKEN" },
})
    .then((res) => res.json())
    .then((data) => {
        L.geoJSON(data.features).addTo(map);
    });
```

### Build Location Directory

```javascript
// Fetch and display all locations
fetch("http://localhost:8000/api/locations?per_page=100", {
    headers: { Authorization: "Bearer YOUR_TOKEN" },
})
    .then((res) => res.json())
    .then((data) => {
        data.data.forEach((location) => {
            // Display in your custom UI
            console.log(
                `${location.location_name} - ${location.category.category_name}`,
            );
        });
    });
```

---

## Version Information

- **API Version:** 1.0
- **Last Updated:** 2024-01-15
- **Base Framework:** Laravel 12
- **Authentication:** Laravel Sanctum

---

For more information, visit the main [README.md](README.md) or contact the development team.
