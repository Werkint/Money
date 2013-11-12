<?php
namespace Werkint\Money\Tests;

use Werkint\Money\Currency;
use Werkint\Money\Money;

/**
 * MoneyTest.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testWrongAmount()
    {
        $cur = new Currency('tst');
        new Money($cur, null);
    }

    /**
     * @depends testWrongAmount
     */
    public function testEquals()
    {
        $cur1 = new Currency('tst1', 2);
        $cur2 = new Currency('tst2', 2);
        $obj1 = new Money($cur1, 100);
        $obj2 = new Money($cur2, 100);
        $obj3 = new Money($cur1, 130);
        $obj4 = new Money($cur1, 100);

        $this->assertFalse($obj1->equals($obj2));
        $this->assertFalse($obj1->equals($obj3));
        $this->assertTrue($obj1->equals($obj1));
        $this->assertTrue($obj1->equals($obj4));

        $this->assertEquals($obj1->getCurrency(), $cur1);
    }

    /**
     * @depends testEquals
     */
    public function testCompare()
    {
        $cur1 = new Currency('tst1', 2);
        $cur2 = new Currency('tst1', 0);
        $obj11 = new Money($cur1, -10);
        $obj12 = new Money($cur1, +0);
        $obj13 = new Money($cur1, +10);
        $obj21 = new Money($cur2, -10);
        $obj22 = new Money($cur2, +0);
        $obj23 = new Money($cur2, +10);

        $this->assertTrue($obj11->lessThan($obj12));
        $this->assertTrue($obj11->lessThan($obj13));
        $this->assertTrue($obj23->greaterThan($obj21));
        $this->assertTrue($obj23->greaterThan($obj22));

        $this->assertEquals(0, $obj12->compare($obj22));
        $this->assertTrue($obj22->equals($obj12));
        $this->assertTrue($obj11->equals($obj21));
        $this->assertTrue($obj13->equals($obj23));

        $this->assertTrue($obj11->equals($obj21));
        $this->assertFalse($obj11->greaterThan($obj23));

        $cur3 = new Currency('tst2', 0);
        $obj3 = new Money($cur3, 10);
        $this->assertFalse($obj3->equals($obj13));
    }

    /**
     * @depends testEquals
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testCompareException()
    {
        $cur1 = new Currency('tst1', 2);
        $cur2 = new Currency('tst2', 2);
        $obj1 = new Money($cur1, 5);
        $obj2 = new Money($cur2, 5);

        $obj1->compare($obj2);
    }

    /**
     * @depends testEquals
     */
    public function testAmount()
    {
        $currency = [
            new Currency('tst', 0),
            new Currency('tst', 2),
            new Currency('tst', 10),
        ];
        $amounts = [
            -10,
            -10.123123,
            +0,
            +0.1231234,
            +10,
            +10.123123,
        ];

        foreach ($currency as $cur) {
            foreach ($amounts as $amount) {
                $obj = new Money($cur, $amount);
                $this->assertEquals($amount, $obj->getAmount());
            }
        }
    }

    /**
     * @depends testAmount
     */
    public function testAmountRandom()
    {
        $currency = [
            new Currency('tst', 0),
            new Currency('tst', 2),
            new Currency('tst', 3),
        ];

        mt_srand(microtime(true));
        foreach ($currency as $cur) {
            for ($i = 0; $i < 10; $i++) {
                $amount = mt_rand(0, 100) - 50;
                $obj = new Money($cur, $amount);
                $this->assertEquals($amount, $obj->getAmount());
            }
        }
    }

    public function testTitle()
    {
        $cur = new Currency('tst', 2);
        $obj = new Money($cur, 5.21);

        $title = '5' . Money::SEPARATOR . '21 TST';
        $this->assertEquals($title, $obj->getTitle());
    }

    /**
     * @depends testAmountRandom
     */
    public function testAdd()
    {
        $cur = new Currency('tst', 0);

        $amount1 = str_pad('', 20, '9') . Money::SEPARATOR . str_pad('', 20, '9');
        $amount2 = '0' . Money::SEPARATOR . str_pad('', 19, '0') . '1';
        $amount3 = '1' . str_pad('', 20, '0');

        $obj1 = new Money($cur, $amount1);
        $obj2 = new Money($cur, $amount2);
        $obj3 = new Money($cur, $amount3);

        $obj_test = $obj1->add($obj2);
        $this->assertTrue($obj3->equals($obj_test));
        $this->assertTrue($amount3 === $obj3->getAmount());
    }

    /**
     * @depends testAmountRandom
     */
    public function testSubstract()
    {
        $cur = new Currency('tst', 0);

        $amount1 = str_pad('', 20, '9') . Money::SEPARATOR . str_pad('', 20, '9');
        $amount2 = '0' . Money::SEPARATOR . str_pad('', 19, '0') . '1';
        $amount3 = '1' . str_pad('', 20, '0');

        $obj1 = new Money($cur, $amount1);
        $obj2 = new Money($cur, $amount2);
        $obj3 = new Money($cur, $amount3);

        $obj_test = $obj3->subtract($obj1);
        $this->assertTrue($obj2->equals($obj_test));
        $this->assertTrue($amount2 === $obj2->getAmount());
    }

    /**
     * @depends testAmountRandom
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testMultiplyException()
    {
        $cur = new Currency('tst');
        $obj = new Money($cur, 5);

        $obj->multiply(null);
    }

    /**
     * @depends testAmountRandom
     * @expectedException \Werkint\Money\Exception\InvalidArgumentException
     */
    public function testDivideException()
    {
        $cur = new Currency('tst');
        $obj = new Money($cur, 5);

        $obj->divide(null);
    }

    /**
     * @depends testMultiplyException
     */
    public function testMultiply()
    {
        $cur = new Currency('tst', 0);
        $amount1 = '1' . str_pad('', 20, '0');
        $amount2 = '5' . str_pad('', 17, '0');
        $obj1 = new Money($cur, $amount1);
        $obj2 = new Money($cur, $amount2);
        $this->assertTrue($obj1->equals($obj2->multiply(200)));
    }

    /**
     * @depends testDivideException
     */
    public function testDivide()
    {
        $cur = new Currency('tst', 0);
        $amount1 = '1' . str_pad('', 20, '0');
        $amount2 = '5' . str_pad('', 17, '0');
        $obj1 = new Money($cur, $amount1);
        $obj2 = new Money($cur, $amount2);
        $this->assertTrue($obj2->equals($obj1->divide(200)));
    }

    /**
     * @depends testCompare
     */
    public function testChecks()
    {
        $cur = new Currency('tst', 0);
        $obj1 = new Money($cur, -10);
        $obj2 = new Money($cur, 0);
        $obj3 = new Money($cur, +10);

        $this->assertTrue($obj2->isZero());
        $this->assertFalse($obj1->isZero());
        $this->assertTrue($obj2->isPositive());
        $this->assertTrue($obj3->isPositive());
        $this->assertFalse($obj1->isPositive());
        $this->assertFalse($obj2->isNegative());
        $this->assertFalse($obj3->isNegative());
        $this->assertTrue($obj1->isNegative());
    }

}
