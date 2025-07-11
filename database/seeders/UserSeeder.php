<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create([
            'tip' => 'rukovodilac'
        ]);

        User::factory()->count(10)->create();

        User::factory()->count(10)->create([
            'tip' => 'vozac'
        ]);

        User::factory()->count(10)->create([
            'tip' => 'tehnolog'
        ]);
    }
}
