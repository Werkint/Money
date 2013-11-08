<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;

/**
 * Class Currency
 * @package Werkint\Money
 */
class Currency implements
    CurrencyInterface
{
    /** @var string */
    protected $name;
    /** @var int */
    protected $subunits;

    /**
     * {@inheritdoc}
     */
    public function __construct($name, $subunits)
    {
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