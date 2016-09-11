<?php
namespace Schweppesale\Access\Application\Services\Users;

use Schweppesale\Access\Domain\Entities\User;
use Schweppesale\Access\Domain\Repositories\PermissionGroup\PermissionGroupInterface;
use Schweppesale\Access\Domain\Repositories\PermissionGroup\PermissionInterface;
use Schweppesale\Access\Domain\Repositories\UserRepository;

/**
 * Class ProfileService
 *
 * @package Schweppesale\Access\Application\Services\Users
 */
class ProfileService
{

    /**
     * @var AuthenticationService
     */
    private $auth;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * ProfileService constructor.
     *
     * @param AuthenticationService $auth
     * @param UserRepository $users
     */
    public function __construct(AuthenticationService $auth, UserRepository $users)
    {
        $this->auth = $auth;
        $this->users = $users;
    }

    /**
     * @param $username
     * @param $email
     * @return User
     */
    public function update($username, $email)
    {
        $user = $this->auth->getUser();
        $user->setName($username);
        $user->setEmail($email);

        return $this->users->save($user);
    }

    /**
     * @param $password
     * @return User
     */
    public function changePassword($password)
    {
        $user = $this->auth->getUser();
        $user->changePassword($password);

        return $this->users->save($user);
    }
}