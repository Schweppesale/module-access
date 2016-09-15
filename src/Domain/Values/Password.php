<?php
namespace Schweppesale\Module\Access\Domain\Services;

/**
 * Class Password
 * @package Schweppesale\Module\Access\Domain\Services
 */
class Password
{

    /**
     * @var string
     */
    private $value;

    /**
     * @var PasswordHasher
     */
    private $hasher;

    /**
     * Password constructor.
     * @param string $value
     * @param PasswordHasher $hasher
     */
    public function __construct(string $value, PasswordHasher $hasher)
    {
        $this->value = $value;
        $this->hasher = $hasher;
    }

    /**
     * @return HashedPassword
     */
    public function hash(): HashedPassword
    {
        return $this->hasher->hash($this);
    }

    /**
     * @return string
     */
    public function _toString()
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

}