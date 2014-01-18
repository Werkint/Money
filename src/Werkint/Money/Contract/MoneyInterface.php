<?php
namespace Werkint\Money\Contract;

use Litipk\BigNumbers\Decimal;
use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class MoneyInterface
 *
 * @package Werkint\Money\Contract
 */
interface MoneyInterface
{
    // floating separator
    const SEPARATOR = '.';
    // places for floor part
    const PLACES_FLOOR = 20;
    // places for fraction
    const PLACES_FRACTION = 10;

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
     * @return string
     */
    public function getAmount();

    /**
     * Returns amount with padded zeros
     *
     * @return string
     */
    public function getAmountFixed();

    /**
     * Returns Decimal object
     *
     * @return Decimal
     */
    public function getAmountDecimal();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param MoneyInterface $addend
     */
    public function add(MoneyInterface $addend);

    /**
     * @param MoneyInterface $subtrahend
     */
    public function subtract(MoneyInterface $subtrahend);

    /**
     * @param float $multiplier
     * @throws InvalidArgumentException
     */
    public function multiply($multiplier);

    /**
     * @param float $divisor
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
