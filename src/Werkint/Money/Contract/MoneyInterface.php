<?php
namespace Werkint\Money\Contract;

use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class MoneyInterface
 * @package Werkint\Money\Contract
 */
interface MoneyInterface
{
    const ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN;
    const ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN;
    const ROUND_HALF_ODD = PHP_ROUND_HALF_ODD;

    /**
     * Creates a Money instance
     * @param  CurrencyInterface $currency
     * @param  float             $amount
     * @return MoneyInterface
     */
    public function __construct(
        CurrencyInterface $currency,
        $amount
    );

    /**
     * @param MoneyInterface $other
     * @return bool
     */
    public function isSameCurrency(MoneyInterface $other);

    /**
     * @param MoneyInterface $other
     * @return bool
     */
    public function equals(MoneyInterface $other);

    /**
     * @param MoneyInterface $other
     * @return int
     * @throws InvalidArgumentException
     */
    public function compare(MoneyInterface $other);

    /**
     * @param MoneyInterface $other
     * @return bool
     * @throws InvalidArgumentException
     */
    public function greaterThan(MoneyInterface $other);

    /**
     * @param MoneyInterface $other
     * @return bool
     * @throws InvalidArgumentException
     */
    public function lessThan(MoneyInterface $other);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @return CurrencyInterface
     */
    public function getCurrency();

    /**
     * @param MoneyInterface $addend
     * @return MoneyInterface
     */
    public function add(MoneyInterface $addend);

    /**
     * @param MoneyInterface $subtrahend
     * @return MoneyInterface
     */
    public function subtract(MoneyInterface $subtrahend);

    /**
     * @param float $multiplier
     * @return MoneyInterface
     * @throws InvalidArgumentException
     */
    public function multiply($multiplier);

    /**
     * @param float $divisor
     * @return MoneyInterface
     * @throws InvalidArgumentException
     */
    public function divide($divisor);

    /**
     * @return bool
     */
    public function isZero();

    /**
     * @return bool
     */
    public function isPositive();

    /**
     * @return bool
     */
    public function isNegative();

}