<?php
namespace Schweppesale\Module\Access\Domain\Services;

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