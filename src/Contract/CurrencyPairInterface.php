<?php
namespace Werkint\Money\Contract;

use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class CurrencyPairInterface
 * @see http://en.wikipedia.org/wiki/Currency_pair
 * @package Werkint\Money\Contract
 */
interface CurrencyPairInterface
{
    /**
     * @param CurrencyInterface $baseCurrency
     * @param CurrencyInterface $counterCurrency
     * @param float             $ratio
     * @throws InvalidArgumentException
     */
    public function __construct(
        CurrencyInterface $baseCurrency,
        CurrencyInterface $counterCurrency,
        $ratio
    );

    /**
     * @param MoneyInterface $money
     * @throws InvalidArgumentException
     * @return MoneyInterface
     */
    public function convert(MoneyInterface $money);

    /**
     * @return CurrencyInterface
     */
    public function getCounterCurrency();

    /**
     * @return CurrencyInterface
     */
    public function getBaseCurrency();

    /**
     * @return float
     */
    public function getRatio();

}