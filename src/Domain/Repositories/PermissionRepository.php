<?php
namespace Schweppesale\Access\Domain\Repositories;

use Schweppesale\Access\Domain\Entities\Permission;

/**
 * Interface PermissionGroupInterface
 *
 * @package Schweppesale\Access\Domain\Repositories\PermissionGroup
 */
interface PermissionRepository
{

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id);

    /**
     * @return Permission[]
     */
    public function fetchAll();

    /**
     * @param $id
     * @return Permission
     */
    public function getById($id);

    /**
     * @param Permission $permissionGroup
     * @return Permission
     */
    public function save(Permission $permissionGroup);
}