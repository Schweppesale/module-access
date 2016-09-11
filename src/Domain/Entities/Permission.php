<?php
namespace Schweppesale\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Permission as PermissionContract;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class Permission
 *
 * @package Modules\Peggy\Entities
 *
 * @ORM\Entity
 * @ORM\Table(name="permissions")
 * @HasLifecycleCallbacks
 */
class Permission implements \JsonSerializable, PermissionContract
{

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var Permission[]
     *
     * @ManyToMany(targetEntity="Permission")
     * @JoinTable(name="permission_dependencies",
     *      joinColumns={@JoinColumn(name="permission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="dependency_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $dependencies;

    /**
     * @var int
     * @ORM\Column(type="string")
     */
    private $displayName;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var PermissionGroup
     *
     * @ManyToOne(targetEntity="\Schweppesale\Access\Domain\Entities\PermissionGroup", inversedBy="permissions", cascade={"all"}, fetch="EAGER")
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $permissionGroup;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $system;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Permission constructor.
     *
     * @param $name
     * @param $displayName
     * @param PermissionGroup|null $permissionGroup
     */
    public function __construct($name, $displayName, PermissionGroup $permissionGroup = null)
    {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->permissionGroup = $permissionGroup;

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
     * @return int
     */
    public function getPermissionGroup()
    {
        return $this->permissionGroup;
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

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
