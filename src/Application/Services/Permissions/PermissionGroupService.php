<?php
namespace Schweppesale\Module\Access\Application\Services\Permissions;

use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository;

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
     * PermissionGroupService constructor.
     *
     * @param PermissionGroupRepository $permissionGroups
     */
    public function __construct(PermissionGroupRepository $permissionGroups)
    {
        $this->permissionGroups = $permissionGroups;
    }

    /**
     * @param $name
     * @param bool|false $system
     * @param null $parentId
     * @param int $sort
     * @return PermissionGroup
     */
    public function create($name, $system = false, $parentId = null, $sort = 0)
    {
        if ($parentId !== null) {
            $parent = $this->permissionGroups->getById($parentId);
            $permissionGroup = new PermissionGroup($name, $system, $parent);
        } else {
            $permissionGroup = new PermissionGroup($name, $system);
        }

        return $this->permissionGroups->save($permissionGroup->setSort($sort));
    }

    /**
     * @param $groupId
     * @return bool
     */
    public function delete($groupId)
    {
        return $this->permissionGroups->delete($groupId);
    }

    /**
     * @return \Schweppesale\Module\Access\Domain\Entities\Permission[]
     */
    public function fetchAll()
    {
        return $this->permissionGroups->fetchAll();
    }

    /**
     * @return \Schweppesale\Module\Access\Domain\Entities\PermissionGroup[]
     */
    public function fetchAllParents()
    {
        return $this->permissionGroups->fetchAllParents();
    }

    /**
     * @param $groupId
     * @return PermissionGroup
     */
    public function getById($groupId)
    {
        return $this->permissionGroups->getById($groupId);
    }

    /**
     * @param $name
     * @return PermissionGroup
     */
    public function getByName($name)
    {
        return $this->permissionGroups->getByName($name);
    }

    /**
     * @param $groupId
     * @param $name
     * @return PermissionGroup
     */
    public function update($groupId, $name)
    {
        $group = $this->permissionGroups->getById($groupId);
        return $this->permissionGroups->save($group->changeName($name));
    }

    /**
     * @param array $order
     */
    public function updateSort(array $order)
    {

    }
}