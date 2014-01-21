<?php
namespace Werkint\Money\Tests;

use Werkint\Money\Currency;

/**
 * CurrencyTest.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class CurrencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testWrongSubunits()
    {
        new Currency('tst1', -1);
    }

    public function testProperties()
    {
        $obj = new Currency('tst', 2);

        $this->assertEquals(2, $obj->getSubunits());
        $this->assertEquals('TST', $obj->getName());
    }

    public function testEquals()
    {
        $obj1 = new Currency('tst1', 2);
        $obj2 = new Currency('tst2', 2);
        $obj3 = new Currency('tst1', 0);

        $this->assertTrue($obj1->equals($obj1));
        $this->assertTrue($obj1->equals($obj3));
        $this->assertFalse($obj1->equals($obj2));
    }

}
