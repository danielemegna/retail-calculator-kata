<?php

class RetailCalculator {

    /** @var float */
    private const UTAH_TAXRATE = 6.85;
    /** @var float */
    private const NEVADA_TAXRATE = 8.00;

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = array_reduce($items, function (float $total, PurchaseItem $item) {
            return $total + $item->getPrice();
        }, 0.0);
        
        $taxRate = $this->taxRateFor($stateCode);
        $taxCoefficient = 1 + ($taxRate / 100);
        return $this->round_up($itemsTotalPrice * $taxCoefficient);
    }

    private function taxRateFor(string $stateCode): float {
        if ($stateCode === 'NV')
          return self::NEVADA_TAXRATE;
        
        return self::UTAH_TAXRATE;
    }

    function round_up(float $value) {
        $precision = 2;
        $multiplier = pow(10, $precision);
        return ceil($value * $multiplier) / $multiplier;
    }

}
