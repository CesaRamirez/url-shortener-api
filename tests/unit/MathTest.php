<?php

use App\Helpers\Math;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MathTest extends TestCase
{
    protected $mappings = [
        1         => 1,
        100       => '1C',
        1000000   => '4c92',
        999999999 => '15FTGf'
     ];
    /**
     * @test Correctly encodes values.
     *
     *
     * @return void
     */
    public function correctly_encodes_values()
    {
        $math = new Math;

        foreach ($this->mappings as $value => $encoded) {
            $this->assertEquals($encoded, $math->toBase($value));
        }
    }
}
