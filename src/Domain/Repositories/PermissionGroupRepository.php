<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;

/**
 * Interface PermissionGroupInterface
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\PermissionGroup
 */
interface PermissionGroupRepository
{

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id);

    /**
     * @return PermissionGroup[]
     */
    public function fetchAll();

    /**
     * @return PermissionGroup[]
     */
    public function fetchAllParents();

    /**
     * @param $id
     * @return PermissionGroup
     */
    public function getById($id);

    /**
     * @param $id
     * @return PermissionGroup
     */
    public function getByName($name);

    /**
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function save(PermissionGroup $permissionGroup);
}