<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyProviderInterface;
use Werkint\Money\Contract\MoneyFactoryInterface;
use Werkint\Money\Exception\InvalidArgumentException;

/**
 * Class MoneyFactory
 *
 * @package Werkint\Money
 * @see     http://www.regular-expressions.info/floatingpoint.html
 */
class MoneyFactory implements
    MoneyFactoryInterface
{
    protected $provider;

    /**
     * @param CurrencyProviderInterface $provider
     */
    public function __construct(
        CurrencyProviderInterface $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function create($currency, $amount)
    {
        $currency = $this->createCurrency($currency);

        return new Money($currency->getName(), $amount);
    }

    /**
     * {@inheritdoc}
     */
    public function createCurrency($class)
    {
        $class = strtolower($class);
        $this->assertCurrencyExists($class);

        return $this->provider->getCurrency($class);
    }

    /**
     * {@inheritdoc}
     */
    public function currencyPairIso($iso)
    {
        $currency = "([A-Z]{2,3})";
        $ratio = "([0-9]*\.?[0-9]+)";
        $pattern = '#' . $currency . '/' . $currency . ' ' . $ratio . '#';

        $matches = [];
        if (!preg_match($pattern, $iso, $matches)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can't create currency pair from ISO string '%s', format of string is invalid",
                    $iso
                )
            );
        }

        return new CurrencyPair(
            $this->createCurrency($matches[1]),
            $this->createCurrency($matches[2]),
            $matches[3]
        );
    }

    // -- Helpers ---------------------------------------

    /**
     * @param string $class
     * @throws Exception\InvalidArgumentException
     */
    protected function assertCurrencyExists($class)
    {
        if (!in_array($class, $this->provider->getList())) {
            throw new InvalidArgumentException('No such currency: ' . $class);
        }
    }

}