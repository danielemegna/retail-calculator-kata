<?php

use PHPUnit\Framework\TestCase;

class AcceptanceTest extends TestCase {

    /** @test */
    public function singleOneHundredDollarsProductInUtah() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([new PurchaseItem(100)], 'UT');

        $this->assertEquals(106.85, $actual);
    }

}
