<?php
namespace Schweppesale\Module\Access\Application\Services\Permissions;

use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class PermissionService
 *
 * @package Schweppesale\Module\Access\Application\Services\Permissions
 */
class PermissionService
{
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var GroupRepository
     */
    private $groups;

    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * PermissionService constructor.
     * @param MapperInterface $mapper
     * @param PermissionRepository $permissions
     * @param GroupRepository $groupService
     */
    public function __construct(
        MapperInterface $mapper,
        PermissionRepository $permissions,
        GroupRepository $groupService
    )
    {
        $this->mapper = $mapper;
        $this->permissions = $permissions;
        $this->groups = $groupService;
    }

    /**
     * @param $name
     * @param $label
     * @param null $groupId
     * @param null $sort
     * @param array $dependencyIds
     * @param bool $system
     * @return Permission
     * @internal param array|null $dependencies
     */
    public function create($name, $label, $groupId = null, $sort, array $dependencyIds = null, $system = false)
    {
        if ($groupId !== null) {
            $group = $this->groups->getById($groupId);
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
        $permission = $this->permissions->save($permission);

        return $this->mapper->map($permission, PermissionDTO::class);
    }

    /**
     * @param $permissionId
     * @return void
     */
    public function delete($permissionId)
    {
        $this->permissions->delete($permissionId);
    }

    /**
     * @return Permission[]
     */
    public function findAll()
    {
        $result = $this->permissions->findAll()->toArray();
        return $this->mapper->mapArray($result, Permission::class, PermissionDTO::class);
    }

    /**
     * @param $permissionId
     * @return Permission
     */
    public function getById($permissionId)
    {
        $permission = $this->permissions->getById($permissionId);
        return $this->mapper->map($permission, PermissionDTO::class);
    }
}