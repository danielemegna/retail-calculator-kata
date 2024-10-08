<?php

class PurchaseItem {

    /** @var float */
    private $price;

    public function __construct(float $price) {
        $this->price = $price;
    }

    public function getPrice(): float {
        return $this->price;
    }
}