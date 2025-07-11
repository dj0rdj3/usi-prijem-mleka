<?php

namespace Tests\Feature;

use App\Models\Domacinstvo;
use Tests\TestCase;
use App\Models\User;

class RegistracijaDomacinstvaTest extends TestCase
{
    /**
     * Test registracije domacinstva
     */
    public function test_domacin_moze_da_registruje_domacinstvo(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('domacinstvo.store'), [
                'naziv' => 'Farma Jovanović',
                'adresa' => 'Petra Drapšina 92, Mošorin',
                'koordinate' => [
                    'lat' => 45.2971903,
                    'lng' => 20.1592866
                ],
                'tipovi_mleka' => ['kravlje'],
                'uslovi' => true,
            ]);

        $domacinstvo = Domacinstvo::where('user_id', $user->id)->first();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('domacinstvo.show', $domacinstvo));
    }
}
