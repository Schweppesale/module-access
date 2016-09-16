<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Core\Collections\Collection;

/**
 * Interface UserRepository
 *
 * @package Schweppesale\Module\Access\Domain\Repositories\User
 */
interface UserRepository
{

    /**
     * @param $userId
     * @param bool|true $softDelete
     * @return bool
     */
    public function delete($userId, $softDelete = true): bool;

    /**
     * @return User[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @return User[]|Collection
     */
    public function findAllBanned(): Collection;

    /**
     * @return User[]|Collection
     */
    public function findAllDeactivated(): Collection;

    /**
     * @return User[]|Collection
     */
    public function findAllDeleted(): Collection;

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email): User;

    /**
     * @param int $id
     * @return User
     */
    public function getById($id): User;

    /**
     * @param string $code
     * @return User
     */
    public function getByConfirmationCode($code): User;

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User;
}
