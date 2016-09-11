<?php
namespace Step\Access\Application\Services\Roles;

use Step\Access\Domain\Entities\Role;
use Step\Access\Domain\Repositories\PermissionGroupRepository;
use Step\Access\Domain\Repositories\PermissionRepository;
use Step\Access\Domain\Repositories\RoleRepository;

/**
 * Class RoleService
 *
 * @package App\Services\Roles
 */
class RoleService
{

    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * @var PermissionGroupRepository
     */
    private $permissionGroups;

    /**
     * RoleService constructor.
     *
     * @param PermissionRepository $permissions
     * @param PermissionGroupRepository $permissionGroups
     * @param RoleRepository $roles
     */
    public function __construct(PermissionRepository $permissions, PermissionGroupRepository $permissionGroups, RoleRepository $roles)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->permissionGroups = $permissionGroups;
    }

    /**
     * @return \Step\Access\Domain\Entities\Role[]
     */
    public function fetchAll()
    {
        return $this->roles->fetchAll();
    }

    /**
     * @param $roleId
     * @return array
     */
    public function editMeta($roleId)
    {
        return [
            'role' => $this->roles->getById($roleId),
            'groups' => $this->permissionGroups->fetchAllParents(),
            'permissions' => $this->permissions->fetchAll(),
        ];
    }

    /**
     * @param array $criteria
     * @return Role
     */
    public function create(array $criteria)
    {
        $name = $criteria['name'];
        $sort = $criteria['sort'];
        $allPermission = (!empty($criteria['associated-permissions']) && strtolower($criteria['associated-permissions']) === 'all') ? true : false;

        $permissions = [];
        if (!empty($criteria['permissions'])) {
            $perms = trim($criteria['permissions']);
            $perms = explode(',', $perms);
            foreach ($perms as $permId) {
                $permissions[] = $this->permissions->getById($permId);
            }
        }

        return $this->roles->save(new Role($name, $sort, $allPermission, $permissions));
    }

    /**
     * @return array
     */
    public function createMeta()
    {
        return [
            'groups' => $this->permissionGroups->fetchAllParents(),
            'permissions' => $this->permissions->fetchAll()
        ];
    }

    /**
     * @param $roleId
     * @param array $criteria
     * @return \Step\Access\Domain\Entities\Role
     */
    public function update($roleId, array $criteria)
    {

        $role = $this->roles->getById($roleId);
        $name = $criteria['name'];
        $sort = $criteria['sort'];
        $allPermission = (!empty($criteria['associated-permissions']) && strtolower($criteria['associated-permissions']) === 'all') ? true : false;

        $permissions = [];
        if ($perms = trim($criteria['permissions'])) {
            $perms = explode(',', $perms);
            foreach ($perms as $permId) {
                $permissions[] = $this->permissions->getById($permId);
            }
        }

        $role->setName($name)
            ->setSort($sort)
            ->setPermissions($permissions)
            ->setAll($allPermission);

        return $this->roles->save($role);
    }

    public function delete($roleId)
    {
        return $this->roles->delete($roleId);
    }
}