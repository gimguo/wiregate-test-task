<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'name' => 'MacBook Pro 16 M3',
            'first_deployed_at' => null,
            'health_lifecycle_value' => 3,
            'health_lifecycle_unit' => 'year',
        ]);

        Device::create([
            'name' => 'Dell Monitor U2721DE',
            'first_deployed_at' => now()->subMonths(2),
            'health_lifecycle_value' => 4,
            'health_lifecycle_unit' => 'year',
        ]);

        Device::create([
            'name' => 'Logitech MX Keys Keyboard',
            'first_deployed_at' => now()->subYear(),
            'health_lifecycle_value' => 3,
            'health_lifecycle_unit' => 'year',
        ]);

        Device::create([
            'name' => 'Logitech MX Master 3 Mouse',
            'first_deployed_at' => now()->subYears(2),
            'health_lifecycle_value' => 3,
            'health_lifecycle_unit' => 'year',
        ]);

        Device::create([
            'name' => 'HP LaserJet Pro M402n',
            'first_deployed_at' => now()->subYears(4),
            'health_lifecycle_value' => 5,
            'health_lifecycle_unit' => 'year',
        ]);
    }
}
