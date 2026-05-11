<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\User;
use App\Models\Category;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Get some categories
        $hospital = Category::where('category_name', 'Hospital')->first();
        $school = Category::where('category_name', 'School')->first();
        $restaurant = Category::where('category_name', 'Restaurant')->first();
        $park = Category::where('category_name', 'Park')->first();

        // Sample locations (using sample coordinates)
        $sampleLocations = [
            [
                'location_name' => 'City Hospital',
                'description' => 'Main city hospital with 24-hour emergency service',
                'latitude' => 28.7041,
                'longitude' => 77.1025,
                'category_id' => $hospital?->id,
                'user_id' => $user->id,
            ],
            [
                'location_name' => 'Central School',
                'description' => 'Primary and secondary education institution',
                'latitude' => 28.6139,
                'longitude' => 77.2090,
                'category_id' => $school?->id,
                'user_id' => $user->id,
            ],
            [
                'location_name' => 'Green Park Restaurant',
                'description' => 'Multi-cuisine restaurant with outdoor seating',
                'latitude' => 28.5355,
                'longitude' => 77.3910,
                'category_id' => $restaurant?->id,
                'user_id' => $user->id,
            ],
            [
                'location_name' => 'Central Park',
                'description' => 'Large public park with gardens and walking trails',
                'latitude' => 28.6295,
                'longitude' => 77.2295,
                'category_id' => $park?->id,
                'user_id' => $user->id,
            ],
        ];

        foreach ($sampleLocations as $location) {
            Location::create($location);
        }
    }
}
