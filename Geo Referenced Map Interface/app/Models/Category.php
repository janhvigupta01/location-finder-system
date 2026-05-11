<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Category Model
 * 
 * Represents different categories for locations
 * (Hospital, School, Tourist Place, Restaurant, Office, etc.)
 */
class Category extends Model
{
    protected $fillable = ['category_name'];

    /**
     * Get all locations for this category
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get predefined categories
     */
    public static function getDefaultCategories()
    {
        return [
            'Hospital',
            'School',
            'Tourist Place',
            'Restaurant',
            'Office',
            'Park',
            'Library',
            'Museum',
            'Shopping Mall',
            'Other',
        ];
    }
}
