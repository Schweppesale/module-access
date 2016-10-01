<?php

namespace Schweppesale\Module\Access\Application\Services\Users;

use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Exceptions\UnauthorizedException;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Access\Domain\Values\User\Status;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class AuthenticationService
 *
 * @package Schweppesale\Module\Access\Application\Services\Users
 */
class AuthenticationService
{

    /**
     * @var Auth
     */
    private $auth;
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * AuthenticationService constructor.
     * @param Auth  $auth
     * @param UserRepository $users
     * @param MapperInterface $mapper
     */
    public function __construct(
        Auth $auth,
        UserRepository $users,
        MapperInterface $mapper
    )
    {
        $this->auth = $auth;
        $this->users = $users;
        $this->mapper = $mapper;
    }

    /**
     * @todo code duplication
     *
     * @param User $user
     * @throws UnauthorizedException
     */
    private function checkUserStatus(User $user)
    {
        if ($user->getStatus() === Status::DISABLED) {
            throw new UnauthorizedException("Your account is currently deactivated.");
        }

        if ($user->getStatus() === Status::BANNED) {
            throw new UnauthorizedException("Your account is currently banned.");
        }

        if ($user->isConfirmed() === false) {
            throw new UnauthorizedException("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user_id) . '">click here</a>' . " to resend the confirmation e-mail.");
        }
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {

        $user = $this->auth->guard()->user();

        if (!$user instanceof User) {
            throw new \UnexpectedValueException('User not logged in!');
        }
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $email
     * @param $password
     * @return void
     * @throws UnauthorizedException
     */
    public function setUserWithCredentials($email, $password)
    {
        if ($this->auth->guard()->validate(['email.email' => $email, 'password' => $password]) === false) {
            throw new UnauthorizedException('These credentials do not match our records.');
        }

        $user = $this->users->getByEmail(new EmailAddress($email));
        $this->checkUserStatus($user);
        $this->auth->guard()->setUser($user);
    }

    /**
     * @param $token
     * @return void
     * @throws UnauthorizedException
     */
    public function setUserWithToken($token)
    {
        try {
            $this->auth->guard()->setUser($this->users->getByAccessToken($token));
        } catch (EntityNotFoundException $ex) {
            throw new UnauthorizedException('Invalid token', 0, $ex);
        }
    }
}