<?php

class RetailCalculator {

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = $this->totalPriceFor($items);

        $discountRate = 0;
        if ($itemsTotalPrice >= 5000.0) {
            $discountRate = 5;
        } else if ($itemsTotalPrice >= 1000.0) {
            $discountRate = 3;
        }

        $discountCoefficient = 1 - ($discountRate / 100);
        $discountedTotalPrice = $itemsTotalPrice * $discountCoefficient;

        $taxRate = $this->taxRateFor($stateCode);
        $taxCoefficient = 1 + ($taxRate / 100);

        return $this->roundUp($discountedTotalPrice * $taxCoefficient);
    }

    /** @param PurchaseItem[] $items */
    private function totalPriceFor(array $items): float {
        return array_reduce($items, function (float $total, PurchaseItem $item) {
            return $total + $item->getPrice();
        }, 0.0);
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

