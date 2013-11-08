<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;
use Werkint\Money\Contract\MoneyInterface;
use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class Money
 * @package Werkint\Money
 */
class Money implements
    MoneyInterface
{
    /** @var int */
    protected $amountSup;
    /** @var int */
    protected $amountSub;

    /** @var CurrencyInterface */
    protected $currency;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        CurrencyInterface $currency,
        $amount
    ) {
        if (!is_numeric($amount)) {
            throw new InvalidArgumentException("Amount should be numeric");
        }

        $this->amountSup = floor($amount);
        $sub = $amount - $this->amountSup;
        $sub /= 1 / $currency->getSubunits();
        $this->amountSub = $sub;
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function isSameCurrency(MoneyInterface $other)
    {
        return $this->currency->equals($other->getCurrency());
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MoneyInterface $other)
    {
        if (!$this->isSameCurrency($other)) {
            return false;
        }
        return $this->getAmount() == $other->getAmount();
    }

    /**
     * {@inheritdoc}
     */
    public function compare(MoneyInterface $other)
    {
        $this->assertSameCurrency($other);
        if ($this->getAmount() == $other->getAmount()) {
            return 0;
        }
        return $this->getAmount() < $other->getAmount() ? -1 : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function greaterThan(MoneyInterface $other)
    {
        return 1 == $this->compare($other);
    }

    /**
     * {@inheritdoc}
     */
    public function lessThan(MoneyInterface $other)
    {
        return -1 == $this->compare($other);
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        $sub = $this->amountSub / $this->currency->getSubunits();
        return $this->amountSup + $sub;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getAmount() . ' ' . $this->getCurrency()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function add(MoneyInterface $money)
    {
        $this->assertSameCurrency($money);

        return new static(
            $this->currency,
            $this->getAmount() + $money->getAmount()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function subtract(MoneyInterface $money)
    {
        $this->assertSameCurrency($money);

        return new static(
            $this->currency,
            $this->getAmount() - $money->getAmount()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function multiply($multiplier)
    {
        $this->assertOperand($multiplier);

        return new Money(
            $this->currency,
            $this->getAmount() * $multiplier
        );
    }

    /**
     * {@inheritdoc}
     */
    public function divide($divisor)
    {
        $this->assertOperand($divisor);

        return new Money(
            $this->currency,
            $this->getAmount() / $divisor
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isZero()
    {
        return $this->getAmount() === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isPositive()
    {
        return $this->getAmount() > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isNegative()
    {
        return $this->getAmount() < 0;
    }

    // -- Helpers ---------------------------------------

    /**
     * @throws InvalidArgumentException
     */
    protected function assertOperand($operand)
    {
        if (!is_int($operand) && !is_float($operand)) {
            throw new InvalidArgumentException('Operand should be an integer or a float');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertSameCurrency(MoneyInterface $other)
    {
        if (!$this->isSameCurrency($other)) {
            throw new InvalidArgumentException('Different currencies');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertRoundingMode($rounding_mode)
    {
        $modes = [
            self::ROUND_HALF_DOWN,
            self::ROUND_HALF_EVEN,
            self::ROUND_HALF_ODD,
            self::ROUND_HALF_UP,
        ];
        if (!in_array($rounding_mode, $modes)) {
            throw new InvalidArgumentException('Rounding mode should be Money::ROUND_HALF_DOWN | Money::ROUND_HALF_EVEN | Money::ROUND_HALF_ODD | Money::ROUND_HALF_UP');
        }
    }

}
