<?php
namespace Werkint\Money;

use Litipk\BigNumbers\Decimal;
use Werkint\Money\Contract\MoneyInterface;
use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class Money
 *
 * @package Werkint\Money
 */
class Money implements
    MoneyInterface
{
    protected $amount;
    protected $currency;

    /**
     * Creates a Money instance
     *
     * @param  string $currency
     * @param  string $amount
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(
        $currency,
        $amount
    ) {
        $this->currency = $currency;
        $this->amount = Decimal::create($amount, static::PLACES_FRACTION);
    }

    /**
     * {@inheritdoc}
     */
    public function isSameCurrency(MoneyInterface $other)
    {
        return $this->currency == $other->getCurrency();
    }

    /**
     * {@inheritdoc}
     */
    public function compare(MoneyInterface $other)
    {
        $this->assertSameCurrency($other);
        return $this->amount->comp($other->getAmountDecimal(), 10);
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MoneyInterface $other)
    {
        if (!$this->isSameCurrency($other)) {
            return false;
        }
        return 0 == $this->compare($other);
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
    public function getAmount($places = null)
    {
        $amount = $this->amount;
        if ($places !== null) {
            $amount = $amount->round($places);
        }
        $amount = (string)$amount;
        $amount = preg_replace('!(\.[0-9]*?)0+$!', '$1', $amount);

        if ($amount[strlen($amount) - 1] == '.') {
            $amount = substr($amount, 0, strlen($amount) - 1);
        }
        return $amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountFixed()
    {
        $amount = explode(static::SEPARATOR, $this->getAmount());
        $ret = str_pad($amount[0], static::PLACES_FLOOR, '0', STR_PAD_LEFT);
        $ret .= static::SEPARATOR;
        $amount = isset($amount[1]) ? $amount[1] : '0';
        $ret .= str_pad($amount, static::PLACES_FRACTION, '0', STR_PAD_RIGHT);
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountDecimal()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getCurrency() . ' ' . $this->getAmount();
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

        return $this->addAmount($money->getAmountDecimal());
    }

    /**
     * {@inheritdoc}
     */
    public function addAmount($addend)
    {
        return new static(
            $this->currency,
            $this->amount->add(Decimal::create($addend, static::PLACES_FRACTION))
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
            $this->amount->sub($money->getAmountDecimal())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function multiply($multiplier)
    {
        $this->assertOperand($multiplier);

        return new static(
            $this->currency,
            $this->amount->mul(Decimal::create($multiplier))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function divide($divisor)
    {
        $this->assertOperand($divisor);

        return new static(
            $this->currency,
            $this->amount->div(Decimal::create($divisor))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isZero()
    {
        return 0 == $this->amount->comp(Decimal::create(0), 10);
    }

    /**
     * {@inheritdoc}
     */
    public function isPositive()
    {
        return 1 == $this->amount->comp(Decimal::create(0), 10);
    }

    /**
     * {@inheritdoc}
     */
    public function isNegative()
    {
        return -1 == $this->amount->comp(Decimal::create(0), 10);
    }

    // -- Helpers ---------------------------------------

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

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

    // -- Serialize ---------------------------------------

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'amount'   => $this->amount,
            'currency' => $this->currency,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'amount'   => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'title'    => $this->getTitle(),
        ];
    }
}
