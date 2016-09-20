<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

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
     * @param $permissionId
     * @return User[]|Collection
     */
    public function findByPermissionId($permissionId): Collection;

    /**
     * @param $token
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByAccessToken($token): User;

    /**
     * @param string $code
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByConfirmationCode($code): User;

    /**
     * @param EmailAddress $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByEmail(EmailAddress $email): User;

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function getById($id): User;

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User;
}
