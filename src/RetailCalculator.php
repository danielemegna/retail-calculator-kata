<?php

class RetailCalculator {

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = array_reduce($items, function (float $total, PurchaseItem $item) {
            return $total + $item->getPrice();
        }, 0.0);
        
        $taxRate = $this->taxRateFor($stateCode);
        $taxCoefficient = 1 + ($taxRate / 100);
        return $this->roundUp($itemsTotalPrice * $taxCoefficient);
    }

    private function taxRateFor(string $stateCode): float {
        if ($stateCode === 'NV')
            return 8.00;
        if ($stateCode === 'TX')
            return 6.25;
        if ($stateCode === 'AL')
            return 4.00;
        if ($stateCode === 'CA')
            return 8.25;
        
        return 6.85;
    }

    private function roundUp(float $value): float {
        $precision = 2;
        $multiplier = pow(10, $precision);
        return ceil($value * $multiplier) / $multiplier;
    }

}
