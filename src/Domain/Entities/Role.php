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

    /**
     * @param Permission $permission
     * @return $this
     */
    public function addPermission(Permission $permission): Role
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function can($permission): bool
    {
        return $this->hasPermissionTo($permission);
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): Role
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Permission[] $permissions
     * @return $this
     */
    public function setPermissions(array $permissions): Role
    {
        $this->permissions = [];
        array_map(function (Permission $permission) {
            $this->addPermission($permission);
        }, $permissions);
        return $this;
    }

    /**
     * @param int $sort
     * @return $this
     */
    public function setSort($sort): Role
    {
        $this->sort = (int)$sort;
        return $this;
    }
}
