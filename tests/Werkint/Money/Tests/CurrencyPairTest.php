<?php
namespace Werkint\Money\Tests;

use Werkint\Money\Currency;
use Werkint\Money\CurrencyPair;
use Werkint\Money\Money;

/**
 * CurrencyPairTest.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class CurrencyPairTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testWrongRatio()
    {
        $cur = new Currency('tst');
        new CurrencyPair($cur, $cur, null);
    }

    /**
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testWrongCurrency()
    {
        $cur1 = new Currency('tst1');
        $cur2 = new Currency('tst2');
        $obj = new CurrencyPair($cur1, $cur2, 1);
        $money = new Money($cur2, 20);
        $obj->convert($money);
    }

    public function testProperties()
    {
        $cur1 = new Currency('tst1');
        $cur2 = new Currency('tst2');
        $ratio = 1.1234;
        $obj = new CurrencyPair($cur1, $cur2, $ratio);

        $this->assertEquals($cur1, $obj->getBaseCurrency());
        $this->assertEquals($cur2, $obj->getCounterCurrency());
        $this->assertEquals($ratio, $obj->getRatio());
    }

    /**
     * @depends testProperties
     */
    public function testConvert()
    {
        $cur1 = new Currency('tst1');
        $cur2 = new Currency('tst2');
        $ratio = 4.5;
        $obj = new CurrencyPair($cur1, $cur2, $ratio);
        $money = new Money($cur1, 20);

        $money = $obj->convert($money);
        $this->assertEquals(90, $money->getAmount());
    }

}
