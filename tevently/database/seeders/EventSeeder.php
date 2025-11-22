<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil organizer pertama (atau buat kalau belum ada)
        $organizer = User::where('role', 'organizer')->where('status', 'approved')->first();

        if (!$organizer) {
            $organizer = User::create([
                'name' => 'Demo Organizer',
                'email' => 'organizer@demo.com',
                'password' => bcrypt('password'),
                'role' => 'organizer',
                'status' => 'approved',
            ]);
            $this->command->info('✅ Demo Organizer created!');
        }

        // Ambil beberapa categories
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('❌ No categories found! Run CategorySeeder first.');
            return;
        }

        $events = [
            [
                'title' => 'Summer Music Festival 2025',
                'description' => 'Join us for the biggest summer music festival featuring top artists from around the world. Experience three days of non-stop music, food, and fun!',
                'location' => 'Central Park, New York',
                'event_date' => Carbon::now()->addMonths(2),
                'start_time' => Carbon::now()->addMonths(2)->setTime(14, 0),
                'end_time' => Carbon::now()->addMonths(2)->setTime(23, 0),
                'max_attendees' => 5000,
                'status' => 'published',
            ],
            [
                'title' => 'Tech Innovation Summit',
                'description' => 'Explore the latest innovations in technology with industry leaders and innovators. Network with professionals and discover cutting-edge solutions.',
                'location' => 'Convention Center, San Francisco',
                'event_date' => Carbon::now()->addMonth(),
                'start_time' => Carbon::now()->addMonth()->setTime(9, 0),
                'end_time' => Carbon::now()->addMonth()->setTime(17, 0),
                'max_attendees' => 1000,
                'status' => 'published',
            ],
            [
                'title' => 'International Food Festival',
                'description' => 'Taste dishes from over 50 countries in one place! Enjoy live cooking demonstrations, food competitions, and cultural performances.',
                'location' => 'Downtown Square, Los Angeles',
                'event_date' => Carbon::now()->addWeeks(3),
                'start_time' => Carbon::now()->addWeeks(3)->setTime(11, 0),
                'end_time' => Carbon::now()->addWeeks(3)->setTime(21, 0),
                'max_attendees' => 3000,
                'status' => 'published',
            ],
            [
                'title' => 'Marathon for Charity',
                'description' => 'Run for a cause! Join thousands of runners in this annual charity marathon. All proceeds go to local community programs.',
                'location' => 'City Stadium, Chicago',
                'event_date' => Carbon::now()->addMonths(3),
                'start_time' => Carbon::now()->addMonths(3)->setTime(6, 0),
                'end_time' => Carbon::now()->addMonths(3)->setTime(12, 0),
                'max_attendees' => 10000,
                'status' => 'published',
            ],
            [
                'title' => 'Art Exhibition: Modern Visions',
                'description' => 'Discover contemporary art from emerging and established artists. A curated collection of paintings, sculptures, and digital art.',
                'location' => 'Art Gallery, Miami',
                'event_date' => Carbon::now()->addWeeks(2),
                'start_time' => Carbon::now()->addWeeks(2)->setTime(10, 0),
                'end_time' => Carbon::now()->addWeeks(2)->setTime(18, 0),
                'max_attendees' => 500,
                'status' => 'published',
            ],
            [
                'title' => 'Startup Pitch Night',
                'description' => 'Watch innovative startups pitch their ideas to top investors. Network with entrepreneurs and learn about the startup ecosystem.',
                'location' => 'Business Hub, Austin',
                'event_date' => Carbon::now()->addWeeks(4),
                'start_time' => Carbon::now()->addWeeks(4)->setTime(18, 0),
                'end_time' => Carbon::now()->addWeeks(4)->setTime(22, 0),
                'max_attendees' => 300,
                'status' => 'published',
            ],
            [
                'title' => 'Comedy Night Live',
                'description' => 'Laugh out loud with the best stand-up comedians! An evening of non-stop comedy featuring local and international talent.',
                'location' => 'Comedy Club, Boston',
                'event_date' => Carbon::now()->addDays(10),
                'start_time' => Carbon::now()->addDays(10)->setTime(20, 0),
                'end_time' => Carbon::now()->addDays(10)->setTime(23, 0),
                'max_attendees' => 200,
                'status' => 'published',
            ],
            [
                'title' => 'Digital Marketing Workshop',
                'description' => 'Learn the latest digital marketing strategies from industry experts. Hands-on workshop covering SEO, social media, and content marketing.',
                'location' => 'Learning Center, Seattle',
                'event_date' => Carbon::now()->addWeeks(5),
                'start_time' => Carbon::now()->addWeeks(5)->setTime(9, 0),
                'end_time' => Carbon::now()->addWeeks(5)->setTime(16, 0),
                'max_attendees' => 150,
                'status' => 'published',
            ],
        ];

        foreach ($events as $index => $eventData) {
            Event::create([
                'organizer_id' => $organizer->id,
                'category_id' => $categories->random()->id,
                'title' => $eventData['title'],
                'description' => $eventData['description'],
                'location' => $eventData['location'],
                'event_date' => $eventData['event_date'],
                'start_time' => $eventData['start_time'],
                'end_time' => $eventData['end_time'],
                'max_attendees' => $eventData['max_attendees'],
                'status' => $eventData['status'],
                'image_url' => null,
            ]);
        }

        $this->command->info('✅ ' . count($events) . ' events seeded successfully!');
    }
}