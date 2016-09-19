<?php
namespace Schweppesale\Module\Access\Infrastructure\Services\PasswordHasher;

use Illuminate\Hashing\BcryptHasher;
use Schweppesale\Module\Access\Domain\Services\PasswordHasher;
use Schweppesale\Module\Access\Domain\Values\HashedPassword;
use Schweppesale\Module\Access\Domain\Values\Password;

class PasswordHasherBcrypt implements PasswordHasher
{

    /**
     * @var BcryptHasher
     */
    private $hasher;

    /**
     * PasswordHasherBcrypt constructor.
     * @param BcryptHasher $hasher
     */
    public function __construct(BcryptHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param Password $password
     * @return HashedPassword
     */
    public function hash(Password $password): HashedPassword
    {
        return new HashedPassword($this->hasher->make($password->value()));
    }
}