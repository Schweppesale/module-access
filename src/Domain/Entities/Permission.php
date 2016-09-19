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
     * @var Group
     */
    private $group;
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
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
     * @param string $name
     * @param string $displayName
     * @param Group $group
     * @param Permission[] $dependencies
     */
    public function __construct(string $name, string $displayName, Group $group, $dependencies = [])
    {
        $this->name = $name;
        $this->group = $group;
        $this->displayName = $displayName;

        $this->setDependencies($dependencies);

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @param Permission $permission
     * @return $this
     */
    public function addDependency(Permission $permission)
    {
        $this->dependencies[] = $permission;

        return $this;
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
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
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
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
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
     * @param Permission[] $dependencies
     * @return $this
     */
    public function setDependencies(array $dependencies)
    {
        $this->dependencies = [];
        array_map(function (Permission $dependency) {
            $this->addDependency($dependency);
        }, $dependencies);

        return $this;
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
     * @param boolean $system
     * @return $this
     */
    public function setSystem(bool $system)
    {
        $this->system = $system;

        return $this;
    }
}
