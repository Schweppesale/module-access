<?php
namespace Schweppesale\Module\Access\Domain\Values;

use Schweppesale\Module\Access\Domain\Services\PasswordHasher;

/**
 * Class Password
 * @package Schweppesale\Module\Access\Domain\Services
 */
class Password
{

    /**
     * @var PasswordHasher
     */
    private $hasher;
    /**
     * @var string
     */
    private $password;

    /**
     * Password constructor.
     * @param string $password
     * @param PasswordHasher $hasher
     */
    public function __construct(string $password, PasswordHasher $hasher)
    {
        $this->password = $password;
        $this->hasher = $hasher;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
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
    public function value(): string
    {
        return $this->password;
    }
}