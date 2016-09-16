<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;

/**
 * Class Role
 *
 * @package Schweppesale\Domain\Entities
 */
class Role implements RoleContract
{

    use HasPermissions;

    /**
     * @var int
     */
    private $all;

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
     * @var Permission[]
     */
    private $permissions;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @var User[]
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
}
