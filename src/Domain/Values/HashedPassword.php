<?php
namespace Schweppesale\Module\Access\Domain\Services;

/**
 * Class HashedPassword
 * @package Schweppesale\Module\Access\Domain\Services
 */
class HashedPassword
{

    /**
     * @var string
     */
    private $value;

    /**
     * HashedPassword constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }
}