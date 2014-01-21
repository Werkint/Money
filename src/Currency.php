<?php
namespace Werkint\Money;

use Werkint\Money\Contract\CurrencyInterface;
use Werkint\Money\Exception\InvalidArgumentException;

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
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(
        $name,
        $subunits = 0
    ) {
        if ($subunits != abs(ceil($subunits))) {
            throw new InvalidArgumentException('Wrong subunits value');
        }

        $this->name = strtoupper($name);
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
    public function getTitle()
    {
        return $this->getName();
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