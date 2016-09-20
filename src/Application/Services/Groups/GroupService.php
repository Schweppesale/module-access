<?php
namespace Schweppesale\Module\Access\Application\Services\Groups;

use Schweppesale\Module\Access\Application\Response\GroupDTO;
use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class GroupService
 * @package Schweppesale\Module\Access\Application\Services\Groups
 */
class GroupService
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
     * @var PermissionService
     */
    private $permissionService;

    /**
     * GroupService constructor.
     * @param MapperInterface $mapper
     * @param GroupRepository $groups
     * @param PermissionService $permissionService
     */
    public function __construct(MapperInterface $mapper, GroupRepository $groups, PermissionService $permissionService)
    {
        $this->mapper = $mapper;
        $this->groups = $groups;
        $this->permissionService = $permissionService;
    }

    /**
     * @param $name
     * @param bool $system
     * @param null $parentId
     * @param int $sort
     * @return GroupDTO
     */
    public function create($name, $system = false, $parentId = null, $sort = 0): GroupDTO
    {
        if ($parentId !== null) {
            $parent = $this->groups->getById($parentId);
            $group = new Group($name, $system, $parent);
        } else {
            $group = new Group($name, $system);
        }
        $group = $this->groups->save($group->setSort($sort));

        return $this->mapper->map($group, GroupDTO::class);
    }

    /**
     * @param $groupId
     * @return void
     */
    public function delete($groupId)
    {
        $this->groups->delete($groupId);
    }

    /**
     * Appends additional data to the PermissionDTO
     *
     * @param GroupDTO $group
     * @param array $options
     * @return GroupDTO
     */
    private function expand(GroupDTO $group, array $options = [])
    {
        $options = array_flip(array_map('strtolower', array_map('trim', $options)));
        if (array_key_exists('all', $options) || array_key_exists('permissionids', $options)) {
            $permissionIds = array_map(function (PermissionDTO $permission) {
                return $permission->getId();
            }, $this->permissionService->findByGroupId($group->getId()));
            $group->setPermissionIds($permissionIds);
        }
        return $group;
    }

    /**
     * @param array $options
     * @return GroupDTO[]
     */
    public function findAll(array $options = [])
    {
        $result = $this->groups->findAll()->toArray();
        $result = $this->mapper->mapArray($result, Group::class, GroupDTO::class);
        if (array_key_exists('expand', $options)) {
            $result = array_map(
                function (GroupDTO $group) use ($options) {
                    return $this->expand($group, (array)$options['expand']);
                },
                $result
            );
        }

        return $result;
    }

    /**
     * @return GroupDTO[]
     */
    public function findAllParents()
    {
        $result = $this->groups->findAllParents()->toArray();
        return $this->mapper->mapArray($result, Group::class, GroupDTO::class);
    }

    /**
     * @param $groupId
     * @return GroupDTO
     */
    public function getById($groupId): GroupDTO
    {
        $result = $this->groups->getById($groupId);
        return $this->mapper->map($result, GroupDTO::class);
    }

    /**
     * @param $name
     * @return GroupDTO
     */
    public function getByName($name) : GroupDTO
    {
        $result = $this->groups->getByName($name);
        return $this->mapper->map($result, GroupDTO::class);
    }

    /**
     * @param $groupId
     * @param $name
     * @return GroupDTO
     */
    public function update($groupId, $name): GroupDTO
    {
        $group = $this->groups->getById($groupId);
        $group = $this->groups->save($group->setName($name));
        return $this->mapper->map($group, GroupDTO::class);
    }
}