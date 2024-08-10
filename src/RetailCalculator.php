<?php

class RetailCalculator {

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = $this->totalPriceFor($items);

        $discountRate = $this->discountRateFor($itemsTotalPrice);
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

    private function discountRateFor(float $totalPrice): int {
        if ($totalPrice < 1000) return 0;
        if ($totalPrice < 5000) return 3;
        if ($totalPrice < 7000) return 5;
        if ($totalPrice < 10000) return 7;
        return 10;
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

