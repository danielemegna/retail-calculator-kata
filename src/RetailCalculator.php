<?php

class RetailCalculator {

    /** @var float */
    private const UTAH_TAXRATE = 6.85;

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = array_reduce($items, function (float $total, PurchaseItem $item) {
            return $total + $item->getPrice();
        }, 0.0);

        $taxCoefficient = 1 + (self::UTAH_TAXRATE / 100);
        return $this->round_up($itemsTotalPrice * $taxCoefficient);
    }

    function round_up(float $value) {
        $precision = 2;
        $multiplier = pow(10, $precision);
        return ceil($value * $multiplier) / $multiplier;
    }

}
