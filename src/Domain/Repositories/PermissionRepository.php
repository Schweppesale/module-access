<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Interface PermissionGroupInterface
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\PermissionGroup
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
     * @param $id
     * @return Permission
     * @throws EntityNotFoundException
     */
    public function getById($id): Permission;

    /**
     * @param Permission $permissionGroup
     * @return Permission
     */
    public function save(Permission $permissionGroup): Permission;
}