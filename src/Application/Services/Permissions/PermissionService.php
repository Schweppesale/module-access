<?php
namespace Schweppesale\Access\Application\Services\Permissions;

use Schweppesale\Access\Domain\Entities\Permission;
use Schweppesale\Access\Domain\Repositories\PermissionGroupRepository;
use Schweppesale\Access\Domain\Repositories\PermissionRepository;

/**
 * Class PermissionService
 *
 * @package Schweppesale\Access\Application\Services\Permissions
 */
class PermissionService
{

    /**
     * @var PermissionGroupRepository
     */
    private $permissionGroups;

    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * PermissionService constructor.
     *
     * @param PermissionRepository $permissions
     * @param PermissionGroupRepository $permissionGroupService
     */
    public function __construct(PermissionRepository $permissions, PermissionGroupRepository $permissionGroupService)
    {
        $this->permissions = $permissions;
        $this->permissionGroups = $permissionGroupService;
    }

    /**
     * @param $name
     * @param $label
     * @param null $groupId
     * @param null $sort
     * @param array|null $dependencies
     * @return Permission
     */
    public function create($name, $label, $groupId = null, $sort, array $dependencyIds = null, $system = false)
    {
        if ($groupId !== null) {
            $group = $this->permissionGroups->getById($groupId);
            $permission = new Permission($name, $label, $group);
        } else {
            $permission = new Permission($name, $label, null);
        }

        $permission->setSort($sort);

        if ($dependencyIds !== null) {
            $dependencies = [];
            foreach ($dependencyIds as $dependencyId) {
                $dependencies[] = $this->permissions->getById($dependencyId);
            }
            $permission->setDependencies($dependencies);
        }

        $permission->setSystem($system);

        return $this->permissions->save($permission);
    }

    /**
     * @param $permissionId
     * @return bool
     */
    public function delete($permissionId)
    {
        return $this->permissions->delete($permissionId);
    }

    /**
     * @return \Schweppesale\Access\Domain\Entities\Permission[]
     */
    public function fetchAll()
    {
        return $this->permissions->fetchAll();
    }

    /**
     * @param $permissionId
     * @return Permission
     */
    public function getById($permissionId)
    {
        return $this->permissions->get($permissionId);
    }
}