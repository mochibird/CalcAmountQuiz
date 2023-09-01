<?php

namespace SuperMarket;

require_once(__DIR__ . '/OrderProcessor.php');
require_once(__DIR__ . '/DiscountCalculator.php');

use SuperMarket\OrderProcessor;
use SuperMarket\DiscountCalculator;

class Shop
{
    public function __construct(
        private string $time,
        private array $itemNumbers,
        private ?OrderProcessor $orderProcessor = null,
    ){
        $this->orderProcessor = $orderProcessor ?? new OrderProcessor(
            new DiscountCalculator()
        );
    }
    public function getTime(): string
    {
        return $this->time;
    }

    public function getItemNumbers()
    {
        return $this->itemNumbers;
    }

    public function getOrderProcessor(): OrderProcessor
    {
        return $this->orderProcessor;
    }

    public function bill(): int
    {
        $this->orderProcessor->calcTotalAmount($this);
        return $this->getOrderProcessor()->getTotalAmount();
    }
}
