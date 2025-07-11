<?php

namespace Tests\Feature;

use App\Models\Domacinstvo;
use Tests\TestCase;
use App\Models\User;

class IzdavanjeRadnogNalogaTest extends TestCase
{
    /**
     * Test izdavanja radnog naloga od strane rukovodioca
     */
    public function test_rukovodilac_moze_da_izda_radni_nalog(): void
    {
        $rukovodilac = User::factory()->create([
            'tip' => 'rukovodilac',
        ]);

        $domacin = User::factory()->create();

        $vozac = User::factory()->create([
            'tip' => 'vozac',
        ]);

        $tehnolog = User::factory()->create([
            'tip' => 'tehnolog',
        ]);

        $domacinstvo = Domacinstvo::factory()->create([
            'user_id' => $domacin->id,
            'tipovi_mleka' => 'kravlje'
        ]);

        $response = $this
            ->actingAs($rukovodilac)
            ->post(route('radni-nalog.store'), [
                'domacinstvo_id' => $domacinstvo->id,
                'vozac_id' => $vozac->id,
                'tehnolog_id' => $tehnolog->id,
                'tip_mleka' => 'kravlje',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));
    }

    public function test_rukovodilac_ne_moze_da_izda_radni_nalog_bez_tipa_mleka(): void
    {
        $rukovodilac = User::factory()->create([
            'tip' => 'rukovodilac',
        ]);

        $domacin = User::factory()->create();

        $vozac = User::factory()->create([
            'tip' => 'vozac',
        ]);

        $tehnolog = User::factory()->create([
            'tip' => 'tehnolog',
        ]);

        $domacinstvo = Domacinstvo::factory()->create([
            'user_id' => $domacin->id,
            'tipovi_mleka' => 'kravlje'
        ]);

        $response = $this
            ->actingAs($rukovodilac)
            ->from(route('radni-nalog.create'))
            ->post(route('radni-nalog.store'), [
                'domacinstvo_id' => $domacinstvo->id,
                'vozac_id' => $vozac->id,
                'tehnolog_id' => $tehnolog->id,
            ]);

        $response
            ->assertSessionHasErrors('tip_mleka')
            ->assertRedirect(route('radni-nalog.create'));
    }
}
