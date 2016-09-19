<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Interface GroupInterface
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\Group
 */
interface PermissionRepository
{

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id): bool;

    /**
     * @return Permission[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @param $userId
     * @return Permission[]|Collection
     */
    public function findByUserId($userId): Collection;

    /**
     * @param $roleId
     * @return Permission[]|Collection
     */
    public function findByRoleId($roleId): Collection;

    /**
     * @param $groupId
     * @return Permission[]|Collection
     */
    public function findByGroupId($groupId): Collection;

    /**
     * @param $id
     * @return Permission
     * @throws EntityNotFoundException
     */
    public function getById($id): Permission;

    /**
     * @param Permission $group
     * @return Permission
     */
    public function save(Permission $group): Permission;
}