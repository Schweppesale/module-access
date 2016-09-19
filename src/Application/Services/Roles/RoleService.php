<?php
namespace Schweppesale\Module\Access\Application\Services\Roles;

use Schweppesale\Module\Access\Application\Response\GroupDTO;
use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Response\RoleDTO;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class RoleService
 *
 * @package App\Services\Roles
 */
class RoleService
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
     * @var RoleRepository
     */
    private $roles;

    /**
     * RoleService constructor.
     * @param MapperInterface $mapper
     * @param PermissionRepository $permissions
     * @param GroupRepository $groups
     * @param RoleRepository $roles
     */
    public function __construct(
        MapperInterface $mapper,
        PermissionRepository $permissions,
        GroupRepository $groups,
        RoleRepository $roles)
    {
        $this->mapper = $mapper;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->groups = $groups;
    }

    /**
     * @param array $criteria
     * @return Role
     */
    public function create(array $criteria)
    {
        $name = $criteria['name'];
        $sort = $criteria['sort'];

        $permissions = [];
        if (!empty($criteria['permissions'])) {
            $perms = $criteria['permissions'];
            foreach ($perms as $permId) {
                $permissions[] = $this->permissions->getById($permId);
            }
        }

        $role = $this->roles->save(new Role($name, $sort, $permissions));
        return $this->mapper->map($role, RoleDTO::class);
    }

    /**
     * @return array
     */
    public function createMeta()
    {
        return [
            'permissions' => $this->mapper->mapArray($this->permissions->findAll()->toArray(), Permission::class, PermissionDTO::class),
            'groups' => $this->mapper->mapArray($this->groups->findAllParents()->toArray(), Group::class, GroupDTO::class)
        ];
    }

    /**
     * @param $roleId
     * @return void
     */
    public function delete($roleId)
    {
        $this->roles->delete($roleId);
    }

    /**
     * @param $roleId
     * @return array
     */
    public function editMeta($roleId)
    {
        return [
            'role' => $this->getById($roleId),
            'permissions' => $this->mapper->mapArray($this->permissions->findAll()->toArray(), Permission::class, PermissionDTO::class),
            'groups' => $this->mapper->mapArray($this->groups->findAllParents()->toArray(), Group::class, GroupDTO::class),
        ];
    }

    /**
     * @return Role[]
     */
    public function findAll()
    {
        $result = $this->roles->findAll();
        return $this->mapper->mapArray($result->toArray(), Role::class, RoleDTO::class);
    }

    /**
     * @todo inefficient
     *
     * @param $permissionId
     * @return RoleDTO[]
     */
    public function findByPermissionId($permissionId)
    {
        $permission = $this->permissions->getById($permissionId);
        $roles = $this->roles->findAll()->toArray();
        $result = array_filter($roles, function (Role $role) use ($permission) {
            return $role->can($permission->getName());
        });
        return $this->mapper->mapArray($result, Role::class, RoleDTO::class);
    }

    /**
     * @param $userId
     * @return RoleDTO[]
     */
    public function findByUserId($userId)
    {
        $result = $this->roles->findByUserId($userId)->toArray();
        return $this->mapper->mapArray($result, Role::class, RoleDTO::class);
    }

    /**
     * @param $roleId
     * @return RoleDTO
     */
    public function getById($roleId): RoleDTO
    {
        $role = $this->roles->getById($roleId);
        return $this->mapper->map($role, RoleDTO::class);
    }

    /**
     * @param $roleId
     * @param array $criteria
     * @return Role
     */
    public function update($roleId, array $criteria)
    {

        $role = $this->roles->getById($roleId);
        $name = $criteria['name'];
        $sort = $criteria['sort'];
        $permissions = [];
        if ($perms = trim($criteria['permissions'])) {
            $perms = explode(',', $perms);
            foreach ($perms as $permId) {
                $permissions[] = $this->permissions->getById($permId);
            }
        }

        $role->setName($name)
            ->setSort($sort)
            ->setPermissions($permissions);

        $role = $this->roles->save($role);
        return $this->mapper->map($role, RoleDTO::class);
    }
}