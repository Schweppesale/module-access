<?php
namespace Schweppesale\Access\Domain\Entities\Traits;

/**
 * Class CanBeAuthenticated
 *
 * @package Schweppesale\Access\Domain\Entities\Traits
 */
trait CanBeAuthenticated
{

    /**
     * @return int
     */
    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    /**
     * @return int
     */
    abstract public function getId();

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}