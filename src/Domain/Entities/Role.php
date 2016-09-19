<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsInterface;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;


/**
 * Class Role
 *
 * @package Schweppesale\Domain\Entities
 */
class Role implements HasPermissionsInterface, RoleContract
{

    use HasPermissions;

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
     * @param array $permissions
     */
    public function __construct($name, $sort, array $permissions)
    {
        $this->name = $name;
        $this->sort = $sort;

        $this->setPermissions($permissions);

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function can($permission)
    {
        return $this->hasPermissionTo($permission);
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
