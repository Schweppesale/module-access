<?php
namespace Schweppesale\Module\Access\Application\Services\Users;

use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\Group\GroupInterface;
use Schweppesale\Module\Access\Domain\Repositories\Group\PermissionInterface;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class ProfileService
 * @package Schweppesale\Module\Access\Application\Services\Users
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
     * @var MapperInterface
     */
    private $mapper;

    /**
     * ProfileService constructor.
     * @param MapperInterface $mapper
     * @param AuthenticationService $auth
     * @param UserRepository $users
     */
    public function __construct(
        MapperInterface $mapper,
        AuthenticationService $auth,
        UserRepository $users
    )
    {
        $this->mapper = $mapper;
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

        $user = $this->users->save($user);
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $password
     * @return User
     */
    public function changePassword($password)
    {
        $user = $this->auth->getUser();
        $user->changePassword($password);

        $user = $this->users->save($user);
        return $this->mapper->map($user, UserDTO::class);
    }
}