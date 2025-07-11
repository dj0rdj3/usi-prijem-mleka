<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class PristupUgovoruTest extends TestCase
{
    /**
     * Test pristupa ruti za ugovor
     */
    public function test_moze_se_pristupiti_ugovoru(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('ugovor'));

        $response->assertStatus(200);
        $response->assertInertia(fn($page) => $page->component('Ugovor'));
    }
}
