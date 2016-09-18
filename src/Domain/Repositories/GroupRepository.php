<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Interface GroupInterface
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\Group
 */
interface GroupRepository
{

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * @return Group[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @return Group[]|Collection
     */
    public function findAllParents(): Collection;

    /**
     * @param $id
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getById($id): Group;

    /**
     * @param $name
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getByName($name): Group;

    /**
     * @param Group $group
     * @return Group
     */
    public function save(Group $group): Group;
}