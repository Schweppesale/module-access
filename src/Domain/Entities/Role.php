<?php
namespace Schweppesale\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;


/**
 * Class Role
 *
 * @package Modules\Peggy\Entities
 *
 * @ORM\Entity
 * @ORM\Table(name="roles")
 * @HasLifecycleCallbacks
 */
class Role implements \JsonSerializable, RoleContract
{

    use HasPermissions;

    /**
     * @var int
     * @ORM\Column(name="`all`", type="boolean")
     */
    private $all;

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
     * @var Permission[]
     *
     * @ManyToMany(targetEntity="Permission")
     * @JoinTable(name="permission_role",
     *      joinColumns={@JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="permission_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $permissions;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var User[]
     *
     * @ManyToMany(targetEntity="User", mappedBy="roles")
     * @JoinTable(name="assigned_roles",
     *      joinColumns={@JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $users;

    /**
     * Role constructor.
     *
     * @param $name
     * @param $sort
     * @param $all
     * @param array $permissions
     */
    public function __construct($name, $sort, $all, array $permissions)
    {
        $this->name = $name;
        $this->sort = $sort;
        $this->all = $all;

        $this->setPermissions($permissions);

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

    }

    /**
     * @return int
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * @param int $all
     * @return $this
     */
    public function setAll($all)
    {
        $this->all = $all;

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
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param Permission[] $permissions
     * @return $this
     */
    public function setPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$permission instanceof Permission) {
                throw new \InvalidArgumentException('Invalid Permission Type');
            }
        }
        $this->permissions = $permissions;
        return $this;
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
        $this->sort = (int)$sort;
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
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
