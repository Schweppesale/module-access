<?php
namespace Schweppesale\Module\Access\Domain\Entities\Traits;

use Schweppesale\Module\Access\Domain\Entities\Role;

/**
 * Class HasPermissions
 *
 * @package Schweppesale\Module\Access\Domain\Entities\Traits
 */
trait HasPermissions
{

    use \LaravelDoctrine\ACL\Permissions\HasPermissions;

    /**
     * @param $permission
     * @return bool
     */
    public function can($permission)
    {

        foreach ($this->getRoles() as $role) {
            if ($role->getAll() === true) {
                return true;
            }
        }

        return $this->hasPermissionTo($permission);
    }

    /**
     * @return Role[]
     */
    abstract public function getRoles();

    /**
     * @param array $permissions
     * @param bool|false $strict
     * @return bool
     */
    public function canMultiple(array $permissions, $strict = false)
    {
        foreach ($this->getRoles() as $role) {
            if ($role->getAll() === true) {
                return true;
            }
        }

        return $this->hasPermissionTo($permissions, $strict);
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        foreach ($this->getRoles() as $ourRole) {
            if ($ourRole->getName() === $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $roles
     * @param bool|true $strict
     * @return bool
     */
    public function hasRoles($roles, $strict = true)
    {
        $ourRoles = $this->getRoles()->map(function (Role $role) {
            return $role->getName();
        })->toArray();

        if ($strict === true) {
            return count(array_intersect($roles, $ourRoles)) == count($roles);
        } else {
            foreach ($ourRoles as $ourRole) {
                if (in_array($ourRole, $roles)) {
                    return true;
                }
            }
        }

        return false;
    }

}