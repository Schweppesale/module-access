<?php
namespace Schweppesale\Module\Access\Domain\Services;

use Schweppesale\Module\Access\Domain\Values\HashedPassword;
use Schweppesale\Module\Access\Domain\Values\Password;

/**
 * Interface PasswordHasher
 * @package Schweppesale\Module\Access\Domain\Services
 */
interface PasswordHasher
{

    /**
     * @param Password $password
     * @return HashedPassword
     */
    public function hash(Password $password): HashedPassword;
}