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
    public function someProductsInUtah() {
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

    /** @test */
    public function someProductsInNevada() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([
            new PurchaseItem(380),
            new PurchaseItem(250),
            new PurchaseItem(155)
        ], 'NV');

        $this->assertEquals(847.80, $actual);
    }

    /** @test */
    public function someProductsInTexas() {
        $retailCalculator = new RetailCalculator();

        $actual = $retailCalculator->totalFor([
            new PurchaseItem(483.15),
            new PurchaseItem(130.90),
            new PurchaseItem(40.70)
        ], 'TX');

        // 695.671875
        $this->assertEquals(695.68, $actual);
    }

}
