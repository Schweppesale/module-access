<?php
namespace Step\Access\Domain\Repositories;

use Step\Access\Domain\Entities\User;

/**
 * Interface UserRepository
 *
 * @package Step\Access\Domain\Repositories\User
 */
interface UserRepository
{

    /**
     * @param $userId
     * @param bool|true $softDelete
     * @return bool
     */
    public function delete($userId, $softDelete = true);

    /**
     * @return User[]
     */
    public function fetchAll();

    /**
     * @return User[]
     */
    public function fetchAllBanned();

    /**
     * @return User[]
     */
    public function fetchAllDeactivated();

    /**
     * @return User[]
     */
    public function fetchAllDeleted();

    /**
     * @param $id
     * @return User|bool
     */
    public function findUserById($id);

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email);

    /**
     * @param int $id
     * @return User
     */
    public function getById($id);

    /**
     * @param string $token
     * @return User
     */
    public function getByToken($token);

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user);
}
