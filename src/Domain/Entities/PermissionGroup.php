<?php
namespace Step\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * Class Company
 *
 * @package Modules\Peggy\Entities
 *
 * @ORM\Entity
 * @ORM\Table(name="permission_groups")
 * @HasLifecycleCallbacks
 */
class PermissionGroup implements \JsonSerializable
{

    /**
     * @var PermissionGroup[]
     *
     * @OneToMany(
     *     targetEntity="PermissionGroup",
     *     cascade={"all"},
     *     orphanRemoval=true,
     *     fetch="EAGER",
     *     mappedBy="parent"
     * )
     */
    private $children;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
     * @ManyToOne(
     *     targetEntity="PermissionGroup",
     *     cascade={"all"},
     *     fetch="EAGER",
     *     inversedBy="children"
     * )
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var Role[]
     *
     * @OneToMany(targetEntity="Permission", mappedBy="permissionGroup")
     */
    private $permissions;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var int
     * @ORM\Column(type="boolean")
     */
    private $system;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
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
     * @return int
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
