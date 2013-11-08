<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;
use Werkint\Money\Contract\CurrencyPairInterface;
use Werkint\Money\Contract\MoneyInterface;
use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class CurrencyPair
 * @see http://en.wikipedia.org/wiki/Currency_pair
 * @package Werkint\Money
 */
class CurrencyPair implements
    CurrencyPairInterface
{
    /** @var CurrencyInterface */
    protected $baseCurrency;

    /** @var CurrencyInterface */
    protected $counterCurrency;

    /** @var float */
    protected $ratio;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        CurrencyInterface $baseCurrency,
        CurrencyInterface $counterCurrency,
        $ratio
    ) {
        if (!is_numeric($ratio)) {
            throw new InvalidArgumentException("Ratio must be numeric");
        }

        $this->counterCurrency = $counterCurrency;
        $this->baseCurrency = $baseCurrency;
        $this->ratio = (float)$ratio;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(MoneyInterface $money)
    {
        if (!$money->getCurrency()->equals($this->baseCurrency)) {
            throw new InvalidArgumentException("The Money has the wrong currency");
        }

        return new Money(
            $this->counterCurrency,
            $money->getAmount() * $this->ratio
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCounterCurrency()
    {
        return $this->counterCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function getRatio()
    {
        return $this->ratio;
    }

}