<?php

namespace SuperMarketTest;

require_once(__DIR__ . '/../../lib/SuperMarket/Shop.php');

use PHPUnit\Framework\TestCase;
use SuperMarket\Shop;

class ShopTest extends TestCase
{
    public function testBill()
    {
        $shop = new Shop('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]);
        $this->assertSame(1298, $shop->bill());
    }
}
