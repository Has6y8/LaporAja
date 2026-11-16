<?php

namespace Database\Seeders;

use App\Models\StaffType;
use Illuminate\Database\Seeder;

class StaffTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['IT Support', 'Bangunan', 'Kelistrikan'];
        
        foreach ($types as $type) {
            StaffType::firstOrCreate(['name' => $type]);
        }
    }
}