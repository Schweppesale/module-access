<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

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
     * @param $userId
     * @return Role[]|Collection
     */
    public function findByUserId($userId): Collection;

    /**
     * @param $id
     * @return Role
     * @throws EntityNotFoundException
     */
    public function getById($id): Role;

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role): Role;
}