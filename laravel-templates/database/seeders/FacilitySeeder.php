<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Conference Room A',
                'building' => 'Main Building',
                'room_number' => '101',
                'type' => 'conference_room',
                'capacity' => 20,
                'description' => 'A modern conference room equipped with presentation facilities.',
                'amenities' => ['Projector', 'Whiteboard', 'Video Conferencing', 'Air Conditioning'],
                'requires_approval' => false,
            ],
            [
                'name' => 'Computer Laboratory',
                'building' => 'IT Building',
                'room_number' => '201',
                'type' => 'laboratory',
                'capacity' => 30,
                'description' => 'Fully equipped computer lab with high-speed internet access.',
                'amenities' => ['30 Desktop Computers', 'Projector', 'Air Conditioning', 'Printer'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Study Room B',
                'building' => 'Library',
                'room_number' => '102',
                'type' => 'study_room',
                'capacity' => 8,
                'description' => 'Quiet study room for group discussions and collaborative work.',
                'amenities' => ['Whiteboard', 'Power Outlets', 'Air Conditioning'],
                'requires_approval' => false,
            ],
            [
                'name' => 'Main Auditorium',
                'building' => 'Main Building',
                'room_number' => 'G01',
                'type' => 'auditorium',
                'capacity' => 200,
                'description' => 'Large auditorium for seminars, lectures, and campus events.',
                'amenities' => ['Stage', 'Sound System', 'Projector', 'Microphones', 'Air Conditioning'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Sports Hall',
                'building' => 'Sports Complex',
                'room_number' => 'S01',
                'type' => 'sports_hall',
                'capacity' => 100,
                'description' => 'Indoor sports facility for basketball, volleyball, and other activities.',
                'amenities' => ['Basketball Court', 'Volleyball Net', 'Scoreboards', 'Locker Rooms'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Science Laboratory',
                'building' => 'Science Building',
                'room_number' => '301',
                'type' => 'laboratory',
                'capacity' => 25,
                'description' => 'Well-equipped science lab for experiments and practical sessions.',
                'amenities' => ['Lab Equipment', 'Safety Gear', 'Fume Hood', 'First Aid Kit'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Classroom 101',
                'building' => 'Academic Building A',
                'room_number' => '101',
                'type' => 'classroom',
                'capacity' => 40,
                'description' => 'Standard classroom with modern teaching facilities.',
                'amenities' => ['Projector', 'Whiteboard', 'Air Conditioning', 'Speaker System'],
                'requires_approval' => false,
            ],
            [
                'name' => 'Classroom 102',
                'building' => 'Academic Building A',
                'room_number' => '102',
                'type' => 'classroom',
                'capacity' => 35,
                'description' => 'Standard classroom suitable for lectures and discussions.',
                'amenities' => ['Projector', 'Whiteboard', 'Air Conditioning'],
                'requires_approval' => false,
            ],
            [
                'name' => 'Meeting Room 1',
                'building' => 'Administration Building',
                'room_number' => '105',
                'type' => 'conference_room',
                'capacity' => 12,
                'description' => 'Small meeting room for departmental meetings.',
                'amenities' => ['TV Screen', 'Whiteboard', 'Video Conferencing'],
                'requires_approval' => false,
            ],
            [
                'name' => 'Art Studio',
                'building' => 'Arts Building',
                'room_number' => '202',
                'type' => 'other',
                'capacity' => 20,
                'description' => 'Creative space for art classes and workshops.',
                'amenities' => ['Easels', 'Art Supplies', 'Natural Lighting', 'Sink'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Music Room',
                'building' => 'Arts Building',
                'room_number' => '203',
                'type' => 'other',
                'capacity' => 15,
                'description' => 'Soundproofed room for music practice and classes.',
                'amenities' => ['Piano', 'Sound System', 'Music Stands', 'Soundproofing'],
                'requires_approval' => true,
            ],
            [
                'name' => 'Study Room C',
                'building' => 'Library',
                'room_number' => '103',
                'type' => 'study_room',
                'capacity' => 6,
                'description' => 'Small study room for focused group work.',
                'amenities' => ['Whiteboard', 'Power Outlets'],
                'requires_approval' => false,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
