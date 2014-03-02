<?php
namespace Werkint\Money\Contract;

use Werkint\Money\Money;

/**
 * Class MoneyFactoryInterface
 *
 * @package Werkint\Money\Contract
 */
interface MoneyFactoryInterface
{
    /**
     * Creates money object
     *
     * @param string $currency
     * @param float  $amount
     * @return MoneyInterface
     */
    public function create($currency, $amount);

    /**
     * @param string $iso String representation of the form "EUR/USD 1.2500"
     * @throws \Exception
     * @return CurrencyPairInterface
     */
    public function currencyPairIso($iso);

}