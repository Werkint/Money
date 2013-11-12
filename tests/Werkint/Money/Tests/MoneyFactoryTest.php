<?php
namespace Werkint\Money\Tests;

use Werkint\Money\ArrayCurrencyProvider;
use Werkint\Money\Currency;
use Werkint\Money\CurrencyPair;
use Werkint\Money\Money;
use Werkint\Money\MoneyFactory;

/**
 * MoneyFactoryTest.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class MoneyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testWrongCurrency()
    {
        $provider = new ArrayCurrencyProvider([]);
        $factory = new MoneyFactory($provider);
        $factory->createCurrency('foobar');
    }

    /**
     * @depends testWrongCurrency
     */
    public function testCreateCurrency()
    {
        $cur = new Currency('foo');
        $provider = new ArrayCurrencyProvider(
            [$cur]
        );
        $factory = new MoneyFactory($provider);

        $this->assertEquals($cur, $factory->createCurrency('foo'));
    }

    /**
     * @depends testCreateCurrency
     */
    public function testCreate()
    {
        $cur1 = new Currency('foo');
        $cur2 = new Currency('bar');
        $provider = new ArrayCurrencyProvider(
            [$cur1, $cur2]
        );
        $factory = new MoneyFactory($provider);

        $obj1 = new Money($cur1, 10);
        $obj2 = new Money($cur2, 10);

        $this->assertTrue($obj1->equals($factory->create('foo', 10)));
        $this->assertTrue($obj2->equals($factory->create('bar', 10)));
        $this->assertFalse($obj1->equals($factory->create('bar', 10)));
        $this->assertFalse($obj2->equals($factory->create('foo', 10)));
        $this->assertFalse($obj1->equals($factory->create('foo', 0)));
    }

    /**
     * @depends testCreateCurrency
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testPairIsoException()
    {
        $cur1 = new Currency('foo');
        $cur2 = new Currency('bar');
        $provider = new ArrayCurrencyProvider(
            [$cur1, $cur2]
        );
        $factory = new MoneyFactory($provider);
        $factory->currencyPairIso('foobar');
    }

    /**
     * @depends testPairIsoException
     */
    public function testPairIso()
    {
        $cur1 = new Currency('foo');
        $cur2 = new Currency('bar');
        $provider = new ArrayCurrencyProvider(
            [$cur1, $cur2]
        );
        $factory = new MoneyFactory($provider);

        $obj = $factory->currencyPairIso('#FOO/BAR 4.21#');

        $this->assertEquals($cur1, $obj->getBaseCurrency());
        $this->assertEquals($cur2, $obj->getCounterCurrency());
        $this->assertEquals(4.21, $obj->getRatio());
    }

}
