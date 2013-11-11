<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;

/**
 * Class Currency
 *
 * @package Werkint\Money
 */
class Currency implements
    CurrencyInterface
{
    protected $name;
    protected $subunits;

    /**
     * @param string $name
     * @param int    $subunits
     */
    public function __construct(
        $name,
        $subunits
    ) {
        $this->name = $name;
        $this->subunits = $subunits;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubunits()
    {
        return $this->subunits;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(CurrencyInterface $other)
    {
        return $this->getName() === $other->getName();
    }
}