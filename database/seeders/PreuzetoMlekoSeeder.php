<?php

namespace Database\Seeders;

use App\Models\PreuzetoMleko;
use App\Models\RadniNalog;
use Illuminate\Database\Seeder;

class PreuzetoMlekoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $radni_nalozi = RadniNalog::all();

        foreach ($radni_nalozi as $nalog) {
            $preuzeto = PreuzetoMleko::fromRadniNalog($nalog);
            $preuzeto->created_at = fake()->dateTimeThisYear();
            $preuzeto->save();
        }
    }
}
