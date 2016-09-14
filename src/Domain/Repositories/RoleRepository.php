<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Role;

/**
 * Interface RoleRepository
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\Role
 */
interface RoleRepository
{

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id);

    /**
     * @return Role[]
     */
    public function fetchAll();

    /**
     * @param $id
     * @return Role
     */
    public function getById($id);

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role);
}