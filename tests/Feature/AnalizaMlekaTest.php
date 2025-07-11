<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\RadniNalog;
use App\Models\Domacinstvo;

class AnalizaMlekaTest extends TestCase
{
    /**
     * Test unosa podataka analize od strane tehnologa
     */
    public function test_tehnolog_moze_da_unese_ispravan_rezultat_analize(): void
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

        $radni_nalog = RadniNalog::create([
            'domacinstvo_id' => $domacinstvo->id,
            'rukovodilac_id' => $rukovodilac->id,
            'vozac_id' => $vozac->id,
            'tehnolog_id' => $tehnolog->id,
            'tip_mleka' => 'kravlje',
            'kolicina_mleka' => 50,
        ]);

        $response = $this
            ->actingAs($tehnolog)
            ->patch(route('radni-nalog.update', $radni_nalog), [
                'procenat_mm' => 2.8,
                'primljeno' => 1,
                'komentar' => 'Pronadjene bakterije, povesti racuna o higijeni'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('radni-nalog.index'));

        $radni_nalog->refresh();

        $this->assertEquals(2.8, $radni_nalog->procenat_mm);
        $this->assertEquals(1, $radni_nalog->primljeno);
        $this->assertStringStartsWith('Pronadjene', $radni_nalog->komentar);
    }

    public function test_tehnolog_ne_moze_da_unese_nepotpun_rezultat_analize(): void
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

        $radni_nalog = RadniNalog::create([
            'domacinstvo_id' => $domacinstvo->id,
            'rukovodilac_id' => $rukovodilac->id,
            'vozac_id' => $vozac->id,
            'tehnolog_id' => $tehnolog->id,
            'tip_mleka' => 'kravlje',
            'kolicina_mleka' => 50,
        ]);

        $response = $this
            ->actingAs($tehnolog)
            ->from(route('radni-nalog.edit', $radni_nalog))
            ->patch(route('radni-nalog.update', $radni_nalog), [
                'primljeno' => 0,
            ]);

        $response
            ->assertSessionHasErrors('komentar')
            ->assertRedirect(route('radni-nalog.edit', $radni_nalog));
    }
}
