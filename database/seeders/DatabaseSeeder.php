<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Slot;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & Customer
        User::create([
            'name' => 'Admin Alan',
            'email' => 'admin@alansalon.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '089523808660',
        ]);

        User::create([
            'name' => 'Eka Putri',
            'email' => 'pelanggan@alansalon.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567890',
        ]);

        // 2. Buat 5 Layanan
        $services = [
            [
                'name' => 'Potong Rambut Pria',
                'category' => 'Potong',
                'description' => 'Potong rambut pria modis sudah termasuk cuci dan styling pomade.',
                'price' => 50000.00,
                'duration_minutes' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Potong Rambut Wanita',
                'category' => 'Potong',
                'description' => 'Potong rambut wanita sesuai bentuk wajah, cuci rambut, dan blow dry.',
                'price' => 80000.00,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Pewarnaan Rambut',
                'category' => 'Pewarnaan',
                'description' => 'Pewarnaan rambut penuh menggunakan produk premium dengan pilihan warna trendi.',
                'price' => 250000.00,
                'duration_minutes' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Hair Treatment (Creambath)',
                'category' => 'Treatment',
                'description' => 'Perawatan creambath tradisional dengan pijatan relaksasi untuk kesehatan kulit kepala.',
                'price' => 120000.00,
                'duration_minutes' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Hair Styling & Blow',
                'category' => 'Styling',
                'description' => 'Catok, keriting, atau blow rambut untuk menghadiri acara formal.',
                'price' => 75000.00,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // 3. Buat Slot Jadwal untuk 7 Hari ke Depan
        $hours = [
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['11:00:00', '12:00:00'],
            ['13:00:00', '14:00:00'],
            ['14:00:00', '15:00:00'],
            ['15:00:00', '16:00:00'],
            ['16:00:00', '17:00:00'],
        ];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i)->format('Y-m-d');
            foreach ($hours as $hour) {
                Slot::create([
                    'date' => $date,
                    'start_time' => $hour[0],
                    'end_time' => $hour[1],
                    'is_available' => true,
                ]);
            }
        }
    }
}
