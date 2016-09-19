<?php
namespace Schweppesale\Module\Access\Application\Services\Permissions;

use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Response\RoleDTO;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Application\Services\Roles\RoleService;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
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
     * @var GroupRepository
     */
    private $groups;
    /**
     * @var MapperInterface
     */
    private $mapper;
    /**
     * @var PermissionRepository
     */
    private $permissions;
    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * PermissionService constructor.
     * @param MapperInterface $mapper
     * @param PermissionRepository $permissions
     * @param GroupRepository $groupService
     * @param UserService $userService
     * @param RoleService $roleService
     */
    public function __construct(
        MapperInterface $mapper,
        PermissionRepository $permissions,
        GroupRepository $groupService,
        UserService $userService,
        RoleService $roleService
    )
    {
        $this->mapper = $mapper;
        $this->permissions = $permissions;
        $this->groups = $groupService;
        $this->userService = $userService;
        $this->roleService = $roleService;
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
     * Appends additional data to the PermissionDTO
     *
     * @param PermissionDTO $permission
     * @param array $options
     * @return PermissionDTO
     */
    private function expand(PermissionDTO $permission, array $options = [])
    {
        $options = array_flip(array_map('strtolower', array_map('trim', $options)));
        if (array_key_exists('all', $options) || array_key_exists('dependencyids', $options)) {
            $dependencyIds = array_map(function (PermissionDTO $permission) {
                return $permission->getId();
            }, $this->findDependenciesById($permission->getId()));
            $permission->setDependencyIds($dependencyIds);
        }

        if (array_key_exists('all', $options) || array_key_exists('userids', $options)) {
            $userIds = array_map(function (UserDTO $user) {
                return $user->getId();
            }, $this->userService->findByPermissionId($permission->getId()));
            $permission->setUserIds($userIds);
        }

        if (array_key_exists('all', $options) || array_key_exists('roleids', $options)) {
            $roleIds = array_map(function (RoleDTO $role) {
                return $role->getId();
            }, $this->roleService->findByPermissionId($permission->getId()));
            $permission->setRoleIds($roleIds);
        }

        return $permission;
    }

    /**
     * @param array $options
     * @return PermissionDTO[]
     */
    public function findAll(array $options = [])
    {
        $permissions = $this->mapper->mapArray(
            $this->permissions->findAll()->toArray(),
            Permission::class,
            PermissionDTO::class
        );

        if (array_key_exists('expand', $options)) {
            $permissions = array_map(
                function (PermissionDTO $permission) use ($options) {
                    return $this->expand($permission, (array)$options['expand']);
                },
                $permissions
            );
        }

        return $permissions;
    }

    /**
     * @param $groupId
     * @param array $options
     * @return PermissionDTO[]
     */
    public function findByGroupId($groupId, array $options = [])
    {
        $result = $this->permissions->findByGroupId($groupId)->toArray();
        $result = $this->mapper->mapArray($result, Permission::class, PermissionDTO::class);
        if (array_key_exists('expand', $options)) {
            $result = array_map(
                function (PermissionDTO $permission) use ($options) {
                    return $this->expand($permission, (array)$options['expand']);
                },
                $result
            );
        }
        return $result;
    }

    /**
     * @param $roleId
     * @param array $options
     * @return PermissionDTO[]
     */
    public function findByRoleId($roleId, array $options = [])
    {
        $result = $this->permissions->findByRoleId($roleId)->toArray();
        $result = $this->mapper->mapArray($result, Permission::class, PermissionDTO::class);
        if (array_key_exists('expand', $options)) {
            $result = array_map(
                function (PermissionDTO $permission) use ($options) {
                    return $this->expand($permission, (array)$options['expand']);
                },
                $result
            );
        }
        return $result;
    }

    /**
     * @param $userId
     * @param array $options
     * @return PermissionDTO[]
     */
    public function findByUserId($userId, array $options = [])
    {
        $result = $this->permissions->findByUserId($userId)->toArray();
        $result = $this->mapper->mapArray($result, Permission::class, PermissionDTO::class);
        if (array_key_exists('expand', $options)) {
            $result = array_map(
                function (PermissionDTO $permission) use ($options) {
                    return $this->expand($permission, (array)$options['expand']);
                },
                $result
            );
        }
        return $result;
    }

    /**
     * @param $permissionId
     * @return PermissionDTO[]
     */
    public function findDependenciesById($permissionId)
    {
        $result = $this->permissions->getById($permissionId)->getDependencies()->toArray();
        return $this->mapper->mapArray($result, Permission::class, PermissionDTO::class);
    }

    /**
     * @param $permissionId
     * @return PermissionDTO
     */
    public function getById($permissionId)
    {
        $permission = $this->permissions->getById($permissionId);
        return $this->mapper->map($permission, PermissionDTO::class);
    }
}