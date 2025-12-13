<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Therapist;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users first
        $this->call(UserSeeder::class);
        
        // Create sample therapists
        $therapists = [
            [
                'name' => 'Sarah Johnson',
                'specialization' => 'facial',
                'bio' => 'Expert in facial treatments with 10 years of experience',
                'is_available' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'specialization' => 'massage',
                'bio' => 'Professional massage therapist specializing in aromatherapy',
                'is_available' => true,
            ],
            [
                'name' => 'Jennifer Lee',
                'specialization' => 'hair_treatment',
                'bio' => 'Hair care specialist with expertise in scalp treatments',
                'is_available' => true,
            ],
            [
                'name' => 'Amanda Chen',
                'specialization' => 'body_treatment',
                'bio' => 'Body treatment expert focusing on skin rejuvenation',
                'is_available' => true,
            ],
            [
                'name' => 'Lisa Anderson',
                'specialization' => 'nail_care',
                'bio' => 'Certified nail technician with artistic flair',
                'is_available' => true,
            ],
        ];

        foreach ($therapists as $therapist) {
            Therapist::create($therapist);
        }

        // Create sample services
        $services = [
            // Facial Services
            [
                'name' => 'Deep Cleansing Facial',
                'description' => 'A thorough facial treatment that cleanses, exfoliates, and hydrates your skin. Perfect for removing impurities and giving your skin a fresh, radiant glow.',
                'price' => 350000,
                'duration' => 60,
                'category' => 'facial',
                'is_active' => true,
            ],
            [
                'name' => 'Anti-Aging Facial',
                'description' => 'Premium anti-aging treatment with collagen infusion and specialized serum to reduce fine lines and wrinkles. Restore your youthful appearance.',
                'price' => 550000,
                'duration' => 90,
                'category' => 'facial',
                'is_active' => true,
            ],
            [
                'name' => 'Acne Treatment Facial',
                'description' => 'Specialized treatment for acne-prone skin using medical-grade products. Includes extraction and healing mask.',
                'price' => 400000,
                'duration' => 75,
                'category' => 'facial',
                'is_active' => true,
            ],
            
            // Massage Services
            [
                'name' => 'Swedish Massage',
                'description' => 'Relaxing full-body massage using gentle, flowing strokes to release tension and improve circulation. Perfect for stress relief.',
                'price' => 450000,
                'duration' => 90,
                'category' => 'massage',
                'is_active' => true,
            ],
            [
                'name' => 'Deep Tissue Massage',
                'description' => 'Intensive massage therapy targeting deep muscle layers to relieve chronic pain and tension. Ideal for athletes and active individuals.',
                'price' => 500000,
                'duration' => 90,
                'category' => 'massage',
                'is_active' => true,
            ],
            [
                'name' => 'Hot Stone Massage',
                'description' => 'Luxurious massage using heated stones to melt away tension and promote deep relaxation. An ultimate spa experience.',
                'price' => 600000,
                'duration' => 120,
                'category' => 'massage',
                'is_active' => true,
            ],
            
            // Hair Treatment Services
            [
                'name' => 'Hair Spa Treatment',
                'description' => 'Complete hair and scalp treatment including deep conditioning, steam, and scalp massage. Restores shine and vitality.',
                'price' => 300000,
                'duration' => 60,
                'category' => 'hair_treatment',
                'is_active' => true,
            ],
            [
                'name' => 'Keratin Treatment',
                'description' => 'Professional keratin treatment to smooth frizzy hair and add incredible shine. Results last up to 3 months.',
                'price' => 800000,
                'duration' => 180,
                'category' => 'hair_treatment',
                'is_active' => true,
            ],
            [
                'name' => 'Scalp Detox Treatment',
                'description' => 'Purifying scalp treatment that removes buildup and promotes healthy hair growth. Includes relaxing head massage.',
                'price' => 350000,
                'duration' => 60,
                'category' => 'hair_treatment',
                'is_active' => true,
            ],
            
            // Body Treatment Services
            [
                'name' => 'Body Scrub & Wrap',
                'description' => 'Exfoliating body scrub followed by nourishing wrap treatment. Leaves skin silky smooth and deeply hydrated.',
                'price' => 500000,
                'duration' => 90,
                'category' => 'body_treatment',
                'is_active' => true,
            ],
            [
                'name' => 'Slimming Treatment',
                'description' => 'Targeted treatment to help reduce cellulite and contour your body. Combines massage and specialized products.',
                'price' => 650000,
                'duration' => 90,
                'category' => 'body_treatment',
                'is_active' => true,
            ],
            [
                'name' => 'Whitening Body Treatment',
                'description' => 'Brightening treatment for even skin tone and radiant complexion. Uses natural ingredients for safe results.',
                'price' => 550000,
                'duration' => 75,
                'category' => 'body_treatment',
                'is_active' => true,
            ],
            
            // Nail Care Services
            [
                'name' => 'Manicure & Pedicure',
                'description' => 'Complete nail care including shaping, cuticle treatment, massage, and polish. Pamper your hands and feet.',
                'price' => 200000,
                'duration' => 60,
                'category' => 'nail_care',
                'is_active' => true,
            ],
            [
                'name' => 'Gel Manicure',
                'description' => 'Long-lasting gel nail polish that stays perfect for weeks. Choose from hundreds of colors.',
                'price' => 250000,
                'duration' => 45,
                'category' => 'nail_care',
                'is_active' => true,
            ],
            [
                'name' => 'Nail Art Design',
                'description' => 'Creative nail art service with custom designs. Express your personality through beautiful nail art.',
                'price' => 350000,
                'duration' => 90,
                'category' => 'nail_care',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('✅ Sample data seeded successfully!');
        $this->command->info('📊 Created ' . count($therapists) . ' therapists');
        $this->command->info('💆 Created ' . count($services) . ' services');
    }
}
