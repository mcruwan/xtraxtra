<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Undergraduate',
            'Graduate',
            'PhD',
            'Online Learning',
            'Scholarship',
            'Admissions',
            'Technology',
            'Sustainability',
            'Diversity',
            'Community Engagement',
            'International',
            'Career Services',
            'Campus Facilities',
            'Sports',
            'Arts & Culture',
            'Health & Wellness',
            'Leadership',
            'Entrepreneurship',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                [
                    'name' => $tag,
                    'slug' => Str::slug($tag),
                ]
            );
        }

        $this->command->info('Tags seeded successfully!');
    }
}
