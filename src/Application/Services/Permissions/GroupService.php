<?php
namespace Schweppesale\Module\Access\Application\Services\Permissions;

use Schweppesale\Module\Access\Application\Response\GroupDTO;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class PermissionService
 *
 * @package Schweppesale\Module\Access\Application\Services\Permissions
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
     * GroupService constructor.
     * @param MapperInterface $mapper
     * @param GroupRepository $groups
     */
    public function __construct(MapperInterface $mapper, GroupRepository $groups)
    {
        $this->mapper = $mapper;
        $this->groups = $groups;
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
     * @return GroupDTO[]
     */
    public function findAll()
    {
        $result = $this->groups->findAll()->toArray();
        return $this->mapper->mapArray($result, Group::class, GroupDTO::class);
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
        $group = $this->groups->save($group->changeName($name));
        return $this->mapper->map($group, GroupDTO::class);
    }
}