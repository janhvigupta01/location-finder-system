<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Location Model
 * 
 * Represents a geo-referenced location with coordinates, 
 * category, and image support.
 */
class Location extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'location_name',
        'description',
        'latitude',
        'longitude',
        'category_id',
        'image',
        'user_id',
    ];

    // Cast attributes to specific types
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the location
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the location
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope: Filter locations by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: Filter locations by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Search locations by name or description
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('location_name', 'like', '%' . $term . '%')
                     ->orWhere('description', 'like', '%' . $term . '%');
    }

    /**
     * Get image URL or default placeholder
     */
    public function getImageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/placeholder.png');
    }
}
