<?php
namespace Werkint\Money\Contract;

/**
 * Class CurrencyProviderInterface
 * @package Werkint\Money\Contract
 */
interface CurrencyProviderInterface
{
    /**
     * Returns currency object
     * @param string $currency
     * @return CurrencyInterface
     */
    public function getCurrency($currency);

    /**
     * List of currencies
     * @return string[]
     */
    public function getList();

}