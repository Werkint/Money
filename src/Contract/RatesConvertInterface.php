<?php
namespace Werkint\Money\Contract;

use Werkint\Money\Exception\UnsupportedCurrencypairException;

/**
 * RatesConvertInterface.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
interface RatesConvertInterface
{
    /**
     * Converts money to default currency
     *
     * @param MoneyInterface $money
     * @return MoneyInterface
     */
    public function toDefault(MoneyInterface $money);

    /**
     * Quickly converts to default currency,
     * possibly with small errors. Should only
     * be used for sorting (never rely on this)
     *
     * @param MoneyInterface $money
     * @return MoneyInterface
     */
    public function toDefaultQuick(MoneyInterface $money);

    /**
     * Converts money instance to another currency
     *
     * @param MoneyInterface $money
     * @param string         $currency
     * @throws UnsupportedCurrencypairException
     * @return MoneyInterface
     */
    public function toCurrency(MoneyInterface $money, $currency);

    /**
     * Quickly onverts money instance to another currency
     *
     * @param MoneyInterface $money
     * @param string         $currency
     * @throws UnsupportedCurrencypairException
     * @return MoneyInterface
     */
    public function toCurrencyQuick(MoneyInterface $money, $currency);
}