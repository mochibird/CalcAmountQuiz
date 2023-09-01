<?php

namespace SuperMarket;

class DiscountCalculator
{
    private const FIRST_ONION_DISCOUNT_AMOUNT = 50;
    private const SECOND_ONION_DISCOUNT_AMOUNT = 100;
    private const FIRST_DISCOUNT_NUM_OF_ONIONS = 3;
    private const SECOND_DISCOUNT_NUM_OF_ONIONS = 5;
    private const SET_DISCOUNT_AMOUNT = 20;
    private const TIME_SALE_START_TIME = '20:00';

    public function __construct(
        private int $discountAmount = 0
    ){
    }

    public function getDiscountAmount(): int
    {
        return $this->discountAmount;
    }

    public function calcDiscount(OrderProcessor $orderProcessor, Shop $ship): void
    {
        $numOfOnion = array_count_values($ship->getItemNumbers())[1];
        $this->calcOnionDiscount($numOfOnion);
        $this->calcSetDiscount($orderProcessor);
        $this->calcTimeSaleDiscount($orderProcessor, $ship);
    }

    private function calcOnionDiscount(int $numOfOnion): void
    {
        $discountAmount = 0;
        if ($numOfOnion === self::SECOND_DISCOUNT_NUM_OF_ONIONS) {
            $discountAmount += self::SECOND_ONION_DISCOUNT_AMOUNT;
        } elseif ($numOfOnion === self::FIRST_DISCOUNT_NUM_OF_ONIONS) {
            $discountAmount += self::FIRST_ONION_DISCOUNT_AMOUNT;
        }
        $this->discountAmount += $discountAmount;
    }

    private function calcSetDiscount(OrderProcessor $orderProcessor): void
    {
        $numOfSet = min([$orderProcessor->getDrink(), $orderProcessor->getLunchBox()]);
        $this->discountAmount += $numOfSet * self::SET_DISCOUNT_AMOUNT;
    }

    private function calcTimeSaleDiscount(OrderProcessor $orderProcessor, Shop $ship): void
    {
        $discountAmount = 0;
        if (strtotime($ship->getTime()) > strtotime(self::TIME_SALE_START_TIME)) {
            $discountAmount = $orderProcessor->getLunchBoxAmount() / 2;
        }
        $this->discountAmount += $discountAmount;
    }
}
