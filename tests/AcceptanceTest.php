<?php

use PHPUnit\Framework\TestCase;

class AcceptanceTest extends TestCase {

    /** @test */
    public function singleOneHundredDollarsProductInUtah() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([new PurchaseItem(100)], 'UT');

        $this->assertEquals(106.85, $actual);
    }

    /** @test */
    public function someProductsInUtahUnderOneThousandDollars() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([
            new PurchaseItem(240),
            new PurchaseItem(170),
            new PurchaseItem(90)
        ], 'UT');

        $this->assertEquals(534.25, $actual);
    }

    /** @test */
    public function roundPriceToCentsUp() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([new PurchaseItem(110.80)], 'UT');

        // 118.3898
        $this->assertEquals(118.39000, $actual);
    }

    /** @test */
    public function alwaysRoundPriceToCentsUpAlsoWhenUnderHalf() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([new PurchaseItem(270.99)], 'UT');

        // 289.552815
        $this->assertEquals(289.56000, $actual);
    }

}
