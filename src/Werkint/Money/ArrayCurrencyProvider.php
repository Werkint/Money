<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;
use Werkint\Money\Contract\CurrencyProviderInterface;

/**
 * ArrayCurrencyProvider.
 *
 * @author Bogdan Yurov <bogdan@yurov.me>
 */
class ArrayCurrencyProvider implements
    CurrencyProviderInterface
{
    protected $list;

    /**
     * @param CurrencyInterface[] $list
     */
    public function __construct(
        array $list
    ) {
        $this->list = [];
        foreach ($list as $currency) {
            $this->list[$currency->getName()] = $currency;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency($currency)
    {
        return $this->list[$currency];
    }

    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        return array_keys($this->list);
    }

}
