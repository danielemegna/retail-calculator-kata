<?php

class RetailCalculator {

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = $this->totalPriceFor($items);
        $discountedTotalPrice = $this->applyDiscount($itemsTotalPrice);
        $taxedTotalPrice = $this->applyTax($discountedTotalPrice, $stateCode);
        return $this->roundUp($taxedTotalPrice);
    }

    /** @param PurchaseItem[] $items */
    private function totalPriceFor(array $items): float {
        return array_reduce($items, function (float $total, PurchaseItem $item) {
            return $total + $item->getPrice();
        }, 0.0);
    }

    private function applyDiscount(float $itemsTotalPrice): float {
        $discountRate = $this->discountRateFor($itemsTotalPrice);
        $discountCoefficient = 1 - ($discountRate / 100);
        return $itemsTotalPrice * $discountCoefficient;
    }

    private function discountRateFor(float $totalPrice): int {
        if ($totalPrice < 1000) return 0;
        if ($totalPrice < 5000) return 3;
        if ($totalPrice < 7000) return 5;
        if ($totalPrice < 10000) return 7;
        if ($totalPrice < 50000) return 10;
        return 15;
    }

    private function applyTax(float $totalPrice, string $stateCode): float {
        $taxRate = $this->taxRateFor($stateCode);
        $taxCoefficient = 1 + ($taxRate / 100);
        return $totalPrice * $taxCoefficient;
    }

    private function taxRateFor(string $stateCode): float {
        switch($stateCode) {
            case 'UT': return 6.85;
            case 'NV': return 8.00;
            case 'TX': return 6.25;
            case 'AL': return 4.00;
            case 'CA': return 8.25;
            default: throw new UnsupportedStateException($stateCode);
        }
    }

    private function roundUp(float $value, int $precision = 2): float {
        $multiplier = pow(10, $precision);
        $valueInCents = bcmul($value, $multiplier, $precision);
        return ceil($valueInCents) / $multiplier;
    }

}

