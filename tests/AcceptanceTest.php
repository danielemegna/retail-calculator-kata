<?php

use PHPUnit\Framework\TestCase;

class AcceptanceTest extends TestCase {
    
    /** @var RetailCalculator */
    private $retailCalculator;

    protected function setUp(): void {
        $this->retailCalculator = new RetailCalculator();
    }

    /** @test */
    public function singleOneHundredDollarsProductInUtah() {
        $items = [new PurchaseItem(100)];
        $actual = $this->retailCalculator->totalFor($items, 'UT');

        $this->assertEquals(106.85, $actual);
    }

    /** @test */
    public function someProductsInUtah() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(240),
            new PurchaseItem(170),
            new PurchaseItem(90)
        ], 'UT');

        $this->assertEquals(534.25, $actual);
    }

    /** @test */
    public function roundPriceToCentsUp() {
        $actual = $this->retailCalculator->totalFor([new PurchaseItem(110.80)], 'UT');

        // 118.3898
        $this->assertEquals(118.39000, $actual);
    }

    /** @test */
    public function alwaysRoundPriceToCentsUpAlsoWhenUnderHalf() {
        $actual = $this->retailCalculator->totalFor([new PurchaseItem(270.99)], 'UT');

        // 289.552815
        $this->assertEquals(289.56000, $actual);
    }

    /** @test */
    public function someProductsInNevada() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(380),
            new PurchaseItem(250),
            new PurchaseItem(155)
        ], 'NV');

        $this->assertEquals(847.80, $actual);
    }

    /** @test */
    public function someProductsInTexas() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(483.15),
            new PurchaseItem(130.90),
            new PurchaseItem(40.70)
        ], 'TX');

        $this->assertEquals(695.68, $actual);
    }

    /** @test */
    public function singleProductInAlabama() {
        $actual = $this->retailCalculator->totalFor([new PurchaseItem(442.90)], 'AL');
        $this->assertEquals(460.62, $actual);
    }

    /** @test */
    public function singleProductInCalifornia() {
        $actual = $this->retailCalculator->totalFor([new PurchaseItem(685.24)], 'CA');
        $this->assertEquals(741.78, $actual);
    }

    /** @test */
    public function applyDiscountForOneThousandDollarsProducts() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(500),
            new PurchaseItem(400),
            new PurchaseItem(100)
        ], 'AL');

        $this->assertEquals(1008.80, $actual);
    }

    /** @test */
    public function discountNotAppliedForOneThousandDollarsShopTaxIncluded() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(500),
            new PurchaseItem(400),
            new PurchaseItem(80),
        ], 'AL');

        $this->assertEquals(1019.20, $actual);
    }

    /** @test */
    public function applyDiscountForThreeThousandDollarsProducts() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(1300),
            new PurchaseItem(1000),
            new PurchaseItem(700)
        ], 'NV');

        $this->assertEquals(3142.8, $actual);
    }

    /** @test */
    public function applyMoreDiscountFromFiveToSevenThousandDollars() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(3500),
            new PurchaseItem(2000),
            new PurchaseItem(400),
            new PurchaseItem(100)
        ], 'NV');

        $this->assertEquals(6156, $actual);
    }

    /** @test */
    public function applyMoreDiscountFromSevenToTenThousandDollars() {
        $actual = $this->retailCalculator->totalFor([
            new PurchaseItem(5000),
            new PurchaseItem(1000),
            new PurchaseItem(800),
            new PurchaseItem(700)
        ], 'AL');

        $this->assertEquals(7254, $actual);
    }

}

