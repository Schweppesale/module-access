<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class PermissionGroup
 *
 * @package Schweppesale\Domain\Entities
 */
class PermissionGroup implements \JsonSerializable
{

    /**
     * @var PermissionGroup[]
     */
    private $children;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var PermissionGroup
     */
    private $parent;

    /**
     * @var Role[]
     */
    private $permissions;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var int
     */
    private $system;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * PermissionGroup constructor.
     *
     * @param $name
     * @param bool|false $system
     * @param PermissionGroup|null $parent
     */
    public function __construct($name, $system = false, PermissionGroup $parent = null)
    {
        $this->name = $name;
        $this->system = $system;
        $this->parent = $parent;
        $this->sort = 0;

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @param $name
     * @return $this
     */
    public function changeName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return PermissionGroup[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
