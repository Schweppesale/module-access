<?php
namespace Schweppesale\Module\Access\Domain\Values;

/**
 * Class HashedPassword
 * @package Schweppesale\Module\Access\Domain\Services
 */
class HashedPassword
{

    /**
     * @var string
     */
    private $password;

    /**
     * HashedPassword constructor.
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
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
        return $this->password;
    }
}