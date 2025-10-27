<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Academic News',
                'slug' => 'academic-news',
                'description' => 'News related to academic programs, courses, and curriculum updates',
            ],
            [
                'name' => 'Research & Innovation',
                'slug' => 'research-innovation',
                'description' => 'Research breakthroughs, grants, and innovative projects',
            ],
            [
                'name' => 'Student Life',
                'slug' => 'student-life',
                'description' => 'Student activities, clubs, organizations, and campus life',
            ],
            [
                'name' => 'Events & Conferences',
                'slug' => 'events-conferences',
                'description' => 'Upcoming events, conferences, seminars, and workshops',
            ],
            [
                'name' => 'Faculty & Staff',
                'slug' => 'faculty-staff',
                'description' => 'Faculty appointments, achievements, and staff updates',
            ],
            [
                'name' => 'Alumni Success',
                'slug' => 'alumni-success',
                'description' => 'Alumni achievements and success stories',
            ],
            [
                'name' => 'Partnerships',
                'slug' => 'partnerships',
                'description' => 'Industry partnerships, collaborations, and MOU announcements',
            ],
            [
                'name' => 'Awards & Recognition',
                'slug' => 'awards-recognition',
                'description' => 'Awards, honors, and recognitions received',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
