<?php
namespace Schweppesale\Module\Access\Application\Services\Permissions;

use Schweppesale\Module\Access\Application\Response\PermissionGroupDTO;
use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class PermissionService
 *
 * @package Schweppesale\Module\Access\Application\Services\Permissions
 */
class PermissionGroupService
{

    /**
     * @var PermissionGroupRepository
     */
    private $permissionGroups;

    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * PermissionGroupService constructor.
     * @param MapperInterface $mapper
     * @param PermissionGroupRepository $permissionGroups
     */
    public function __construct(MapperInterface $mapper, PermissionGroupRepository $permissionGroups)
    {
        $this->mapper = $mapper;
        $this->permissionGroups = $permissionGroups;
    }

    /**
     * @param $name
     * @param bool $system
     * @param null $parentId
     * @param int $sort
     * @return PermissionGroupDTO
     */
    public function create($name, $system = false, $parentId = null, $sort = 0): PermissionGroupDTO
    {
        if ($parentId !== null) {
            $parent = $this->permissionGroups->getById($parentId);
            $permissionGroup = new PermissionGroup($name, $system, $parent);
        } else {
            $permissionGroup = new PermissionGroup($name, $system);
        }
        $permissionGroup = $this->permissionGroups->save($permissionGroup->setSort($sort));

        return $this->mapper->map($permissionGroup, PermissionGroupDTO::class);
    }

    /**
     * @param $groupId
     * @return void
     */
    public function delete($groupId)
    {
        $this->permissionGroups->delete($groupId);
    }

    /**
     * @return PermissionGroupDTO[]
     */
    public function findAll()
    {
        $result = $this->permissionGroups->findAll()->toArray();
        return $this->mapper->mapArray($result, PermissionGroup::class, PermissionGroupDTO::class);
    }

    /**
     * @return PermissionGroupDTO[]
     */
    public function findAllParents()
    {
        $result = $this->permissionGroups->findAllParents()->toArray();
        return $this->mapper->mapArray($result, PermissionGroup::class, PermissionGroupDTO::class);
    }

    /**
     * @param $groupId
     * @return PermissionGroupDTO
     */
    public function getById($groupId): PermissionGroupDTO
    {
        $result = $this->permissionGroups->getById($groupId);
        return $this->mapper->map($result, PermissionGroupDTO::class);
    }

    /**
     * @param $name
     * @return PermissionGroupDTO
     */
    public function getByName($name) : PermissionGroupDTO
    {
        $result = $this->permissionGroups->getByName($name);
        return $this->mapper->map($result, PermissionGroupDTO::class);
    }

    /**
     * @param $groupId
     * @param $name
     * @return PermissionGroupDTO
     */
    public function update($groupId, $name): PermissionGroupDTO
    {
        $group = $this->permissionGroups->getById($groupId);
        $group = $this->permissionGroups->save($group->changeName($name));
        return $this->mapper->map($group, PermissionGroupDTO::class);
    }
}