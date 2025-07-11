<?php

namespace Database\Seeders;

use App\Models\Domacinstvo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DomacinstvoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domacini = User::where('tip', 'domacin')->get();

        foreach ($domacini as $domacin) {
            Domacinstvo::factory()->create([
                'user_id' => $domacin->id,
            ]);
        }
    }
}
