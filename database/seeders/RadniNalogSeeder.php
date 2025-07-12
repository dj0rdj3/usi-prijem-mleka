<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Domacinstvo;
use App\Models\RadniNalog;
use Illuminate\Database\Seeder;

class RadniNalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rukovodioci = User::where('tip', 'rukovodilac')->get();
        $domacinstva = Domacinstvo::all();
        $vozaci = User::where('tip', 'vozac')->get();
        $tehnolozi = User::where('tip', 'tehnolog')->get();

        for ($i = 0; $i < 100; $i++) {
            $domacinstvo = $domacinstva->random();
            RadniNalog::factory()->create([
                'rukovodilac_id' => $rukovodioci->random()->id,
                'domacinstvo_id' => $domacinstvo->id,
                'vozac_id' => $vozaci->random()->id,
                'tehnolog_id' => $tehnolozi->random()->id,
                'tip_mleka' => collect($domacinstvo->tipovi_mleka)->random()
            ]);
        }
    }
}
