<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery; // Mengacu pada model Gallery

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan 6 data ke tabel galleries

        Gallery::create([
            'title' => 'Beautiful Sunset',
            'description' => 'A stunning view of the sunset at the beach.',
            'picture' => 'sunset.jpg',
        ]);

        Gallery::create([
            'title' => 'Mountain Adventure',
            'description' => 'A breathtaking photo from a recent mountain hike.',
            'picture' => 'mountain.jpg',
        ]);

        Gallery::create([
            'title' => 'City Lights',
            'description' => 'The vibrant city lights at night.',
            'picture' => 'city_lights.jpg',
        ]);

        Gallery::create([
            'title' => 'Wildlife Safari',
            'description' => 'Close-up shot of a lion in the wild.',
            'picture' => 'wildlife_safari.jpg',
        ]);

        Gallery::create([
            'title' => 'Autumn Forest',
            'description' => 'A beautiful autumn forest with colorful leaves.',
            'picture' => 'autumn_forest.jpg',
        ]);

        Gallery::create([
            'title' => 'Winter Wonderland',
            'description' => 'A peaceful snowy landscape during winter.',
            'picture' => 'winter_wonderland.jpg',
        ]);
    }
}
