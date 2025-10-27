<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NewsSubmission;
use App\Models\Tag;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test university (active)
        $university = University::create([
            'name' => 'AppliedHE University',
            'domain' => 'appliedhe.edu',
            'contact_email' => 'info@appliedhe.edu',
            'status' => 'active',
        ]);

        $this->command->info("✓ Created university: {$university->name}");

        // Create a test user for this university
        $user = User::create([
            'name' => 'Ruwan',
            'email' => 'ruwan@appliedhe.edu',
            'password' => Hash::make('password'),
            'university_id' => $university->id,
            'role' => 'university_user',
            'status' => 'active',
        ]);

        $this->command->info("✓ Created user: {$user->email}");

        // Get some categories and tags
        $categories = Category::take(3)->pluck('id')->toArray();
        $tags = Tag::take(5)->pluck('id')->toArray();

        // Create sample news submissions with different statuses
        $newsData = [
            [
                'title' => 'New Research Center Opens at AppliedHE University',
                'excerpt' => 'Our state-of-the-art research facility is now open to students and faculty.',
                'content' => '<p>We are excited to announce the opening of our new Research and Innovation Center. This facility will provide cutting-edge resources for groundbreaking research across multiple disciplines.</p><p>The center features modern laboratories, collaborative workspaces, and advanced equipment to support our research community.</p>',
                'status' => 'published',
                'submitted_at' => now()->subDays(10),
                'approved_at' => now()->subDays(8),
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Student Team Wins National Innovation Competition',
                'excerpt' => 'Our engineering students took first place in the prestigious National Innovation Challenge.',
                'content' => '<p>A team of four engineering students from AppliedHE University has won the National Innovation Challenge with their groundbreaking sustainable energy solution.</p><p>The competition saw over 100 teams from universities across the country compete for the top prize.</p>',
                'status' => 'approved',
                'submitted_at' => now()->subDays(5),
                'approved_at' => now()->subDays(3),
            ],
            [
                'title' => 'Applications Open for Fall 2025 Graduate Programs',
                'excerpt' => 'We are now accepting applications for our graduate programs starting Fall 2025.',
                'content' => '<p>AppliedHE University is now accepting applications for our Fall 2025 graduate programs across all departments.</p><p>We offer Master\'s and PhD programs in various fields with competitive scholarships available.</p>',
                'status' => 'pending',
                'submitted_at' => now()->subDays(2),
            ],
            [
                'title' => 'New Partnership with Industry Leaders Announced',
                'excerpt' => 'Strategic partnership will provide internship opportunities and research funding.',
                'content' => '<p>We are pleased to announce a new partnership with leading technology companies that will benefit our students and research programs.</p>',
                'status' => 'draft',
            ],
            [
                'title' => 'Campus Sustainability Initiative Reaches Major Milestone',
                'excerpt' => 'Our green campus initiative has reduced carbon emissions by 40%.',
                'content' => '<p>The AppliedHE University campus sustainability program has achieved remarkable results in its first year, reducing our carbon footprint significantly.</p>',
                'status' => 'rejected',
                'submitted_at' => now()->subDays(15),
                'rejection_reason' => 'This news is outdated. Please submit with updated statistics and recent data.',
            ],
        ];

        foreach ($newsData as $index => $data) {
            $news = NewsSubmission::create([
                'university_id' => $university->id,
                'user_id' => $user->id,
                'title' => $data['title'],
                'slug' => \Illuminate\Support\Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'status' => $data['status'],
                'submitted_at' => $data['submitted_at'] ?? null,
                'approved_at' => $data['approved_at'] ?? null,
                'published_at' => $data['published_at'] ?? null,
                'rejection_reason' => $data['rejection_reason'] ?? null,
                'approved_by' => ($data['approved_at'] ?? false) ? 1 : null, // Super Admin
            ]);

            // Attach random categories and tags
            $news->categories()->attach(array_slice($categories, 0, rand(1, 2)));
            $news->tags()->attach(array_slice($tags, 0, rand(2, 4)));

            $this->command->info("✓ Created news: {$news->title} ({$news->status})");
        }

        $this->command->info('');
        $this->command->info('🎉 Test data created successfully!');
        $this->command->info('');
        $this->command->info('📧 Test University User Login:');
        $this->command->info('   Email: ruwan@appliedhe.edu');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('📧 Super Admin Login:');
        $this->command->info('   Email: admin@xtraxtra.com');
        $this->command->info('   Password: password');
    }
}
