<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class PromenaTipaKorisnikaTest extends TestCase
{
    /**
     * Test menjanja tipa korisnika od strane rukovodioca
     */
    public function test_rukovodilac_moze_da_promeni_tip_korisnika(): void
    {
        $rukovodilac = User::factory()->create([
            'tip' => 'rukovodilac',
        ]);

        $zaposleni = User::factory()->create([
            'tip' => 'vozac',
        ]);

        $response = $this
            ->actingAs($rukovodilac)
            ->patch(route('zaposleni.update', $zaposleni), [
                'tip' => 'tehnolog',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('zaposleni.index'));
    }

    public function test_rukovodilac_ne_moze_da_promeni_tip_korisnika_na_rukovodilac(): void
    {
        $rukovodilac = User::factory()->create([
            'tip' => 'rukovodilac',
        ]);

        $zaposleni = User::factory()->create([
            'tip' => 'vozac',
        ]);

        $response = $this
            ->actingAs($rukovodilac)
            ->from(route('zaposleni.index'))
            ->patch(route('zaposleni.update', $zaposleni), [
                'tip' => 'rukovodilac',
            ]);

        $response
            ->assertSessionHasErrors('tip')
            ->assertRedirect(route('zaposleni.index'));
    }
}
