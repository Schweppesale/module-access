<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Permission as PermissionContract;

/**
 * Class Permission
 *
 * @package Schweppesale\Domain\Entities
 */
class Permission implements PermissionContract
{

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var Permission[]
     */
    private $dependencies;

    /**
     * @var int
     */
    private $displayName;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Group
     */
    private $group;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var bool
     */
    private $system;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Permission constructor.
     * @param $name
     * @param $displayName
     * @param Group $group
     * @param array $dependencies
     */
    public function __construct($name, $displayName, Group $group, $dependencies = [])
    {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->dependencies = $dependencies;
        $this->group = $group;

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Permission[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param Permission[] $dependencies
     * @return $this
     */
    public function setDependencies(array $dependencies)
    {
        foreach ($dependencies as $dependency) {
            if (!$dependency instanceof Permission) {
                throw new \InvalidArgumentException('Invalid Permission Entity');
            }
        }
        $this->dependencies = $dependencies;
        return $this;
    }

    /**
     * @return int
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return boolean
     */
    public function isSystem()
    {
        return $this->system;
    }

    /**
     * @param boolean $system
     * @return $this
     */
    public function setSystem($system)
    {
        $this->system = $system;
        return $this;
    }
}
