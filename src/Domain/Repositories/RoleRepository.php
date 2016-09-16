<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Core\Collections\Collection;

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
    public function delete($id): bool;

    /**
     * @return Role[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @param $id
     * @return Role
     */
    public function getById($id): Role;

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role): Role;
}