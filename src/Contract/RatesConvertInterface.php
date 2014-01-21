<?php
namespace Werkint\Money\Contract;

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
}