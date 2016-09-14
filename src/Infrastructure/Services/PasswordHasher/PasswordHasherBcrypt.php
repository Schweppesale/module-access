<?php
namespace Schweppesale\Module\Access\Infrastructure\Services\PasswordHasher;

use Illuminate\Hashing\BcryptHasher;
use Schweppesale\Module\Access\Domain\Services\HashedPassword;
use Schweppesale\Module\Access\Domain\Services\Password;
use Schweppesale\Module\Access\Domain\Services\PasswordHasher;

class PasswordHasherBcrypt implements PasswordHasher  {

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