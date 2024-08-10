<?php

class RetailCalculator {

    /** @var float */
    private const BIG_SHOP_DISCOUNT_RATE = 3;

    /** @param PurchaseItem[] $items */
    public function totalFor(array $items, string $stateCode): float {
        $itemsTotalPrice = $this->totalPriceFor($items);

        if ($itemsTotalPrice >= 1000.0) {
            $discountRate = 1 - (self::BIG_SHOP_DISCOUNT_RATE / 100);
            $itemsTotalPrice *= $discountRate;
        }

        $taxRate = $this->taxRateFor($stateCode);
        $taxCoefficient = 1 + ($taxRate / 100);
        return $this->roundUp($itemsTotalPrice * $taxCoefficient);
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

