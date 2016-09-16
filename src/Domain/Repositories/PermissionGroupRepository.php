<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Core\Collections\Collection;

/**
 * Interface PermissionGroupInterface
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\PermissionGroup
 */
interface PermissionGroupRepository
{

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * @return PermissionGroup[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @return PermissionGroup[]|Collection
     */
    public function findAllParents(): Collection;

    /**
     * @param $id
     * @return PermissionGroup
     */
    public function getById($id): PermissionGroup;

    /**
     * @param $name
     * @return PermissionGroup
     * @internal param $id
     */
    public function getByName($name): PermissionGroup;

    /**
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function save(PermissionGroup $permissionGroup): PermissionGroup;
}