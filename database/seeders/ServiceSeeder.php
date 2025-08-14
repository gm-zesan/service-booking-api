<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = array(
            [
                'name' => 'Plumbing',
                'description' => 'Fix leaks, install pipes, and other plumbing services.',
                'price' => 500.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Electrician',
                'description' => 'Electrical wiring, fixing short circuits, installing lights.',
                'price' => 800.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cleaning',
                'description' => 'Home or office cleaning services.',
                'price' => 300.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        foreach($services as $service){
            Service::create($service);
        }

    }
}
