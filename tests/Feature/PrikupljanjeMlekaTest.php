<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Domacinstvo;
use App\Models\RadniNalog;

class PrikupljanjeMlekaTest extends TestCase
{
    /**
     * Test prikupljanja mleka od strane vozaca
     */
    public function test_vozac_moze_da_unese_kolicinu_mleka(): void
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
        ]);

        $response = $this
            ->actingAs($vozac)
            ->patch(route('radni-nalog.update', $radni_nalog), [
                'kolicina_mleka' => 50,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('radni-nalog.index'));

        $radni_nalog->refresh();

        $this->assertEquals(50, $radni_nalog->kolicina_mleka);
    }

    public function test_vozac_moze_da_prekine_nalog_zbog_karence(): void
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
        ]);

        $response = $this
            ->actingAs($vozac)
            ->patch(route('radni-nalog.update', $radni_nalog), [
                'komentar' => 'Karenca do 21.7.2025.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('radni-nalog.index'));

        $radni_nalog->refresh();

        $this->assertEquals(0, $radni_nalog->primljeno);
        $this->assertStringStartsWith('Karenca', $radni_nalog->komentar);
    }
}
