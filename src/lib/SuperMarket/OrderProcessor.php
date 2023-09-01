<?php

namespace SuperMarket;

class OrderProcessor
{
    public const TAX = 10;
    public const CATEGORIES = [
        1 => ['price' => 100, 'type' => ''],
        2 => ['price' => 150, 'type' => ''],
        3 => ['price' => 200, 'type' => ''],
        4 => ['price' => 350, 'type' => ''],
        5 => ['price' => 180, 'type' => 'drink'],
        6 => ['price' => 220, 'type' => ''],
        7 => ['price' => 440, 'type' => 'lunchBox'],
        8 => ['price' => 380, 'type' => 'lunchBox'],
        9 => ['price' => 80, 'type' => 'drink'],
        10 => ['price' => 100, 'type' => 'drink'],
    ];

    public function __construct(
        private DiscountCalculator $discountCalculator,
        private int $totalAmount = 0,
        private int $drink = 0,
        private int $lunchBox = 0,
        private int $lunchBoxAmount = 0
    ) {
    }

    public function getDiscountCalculator(): DiscountCalculator
    {
        return $this->discountCalculator;
    }

    public function getDrink(): int
    {
        return $this->drink;
    }

    public function getLunchBox(): int
    {
        return $this->lunchBox;
    }

    public function getLunchBoxAmount(): int
    {
        return $this->lunchBoxAmount;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    public function calcTotalAmount(Shop $ship): void
    {
        foreach ($ship->getItemNumbers() as $num) {
            $this->totalAmount += self::CATEGORIES[$num]['price'];
                if (self::CATEGORIES[$num]['type'] === 'drink') {
                    $this->drink++;
                } elseif (self::CATEGORIES[$num]['type'] === 'lunchBox') {
                    $this->lunchBox++;
                    $this->lunchBoxAmount += self::CATEGORIES[$num]['price'];
                }
            }
        $this->getDiscountCalculator()->calcDiscount($this, $ship);
        $discountAmount = $this->getDiscountCalculator()->getDiscountAmount();
        $this->totalAmount -= $discountAmount;
        $this->totalAmount = (int)$this->totalAmount * (100 + self::TAX) / 100;
    }
}
