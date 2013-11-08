<?php
namespace Werkint\Money\Contract;

/**
 * Class CurrencyInterface
 * @package Werkint\Money\Contract
 */
interface CurrencyInterface
{
    /**
     * Currency name
     * @return string
     */
    public function getName();

    /**
     * Subunit fraction
     * @return string
     */
    public function getSubunits();

    /**
     * If two currencies are equal
     * @param CurrencyInterface $other
     * @return bool
     */
    public function equals(CurrencyInterface $other);

    /**
     * @param string $name
     * @param int    $subunits
     */
    public function __construct($name, $subunits);

}