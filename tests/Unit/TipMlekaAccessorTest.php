<?php

namespace Tests\Unit;

use App\Models\Domacinstvo;
use PHPUnit\Framework\TestCase;

class TipMlekaAccessorTest extends TestCase
{
    /**
     * Test tip_mleka accessora domacinstva
     */
    public function test_tip_mleka_accessor_vraca_korektno_ime_mleka(): void
    {
        $domacinstvo = new Domacinstvo([
            'tipovi_mleka' => 'kravlje,ovcije'
        ]);

        $result = $domacinstvo->tipovi_mleka;
        $this->assertIsArray($result);
        $this->assertEquals([
            'Kravlje',
            'Ovčije'
        ], $result);
    }
}
