<?php

namespace Schweppesale\Module\Access\Application\Services\Users;

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
 * Class TokenService
 * @package Schweppesale\Module\Access\Application\Services\Users
 */
class TokenService
{

    /**
     * @var Guard
     */
    private $guard;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * TokenService constructor.
     * @param Guard $guard
     * @param UserRepository $users
     */
    public function __construct(
        Guard $guard,
        UserRepository $users
    )
    {
        $this->guard = $guard;
        $this->users = $users;
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
     * @param $email
     * @param $password
     * @param $token
     * @return bool
     * @throws UnauthorizedException
     */
    public function destroyToken($token)
    {
        $user = $this->users->getByAccessToken($token);
        $user->destroyApiToken();
        $this->users->save($user->destroyApiToken());

        return true;
    }

    /**
     * @param $email
     * @param $password
     * @return string
     * @throws UnauthorizedException
     */
    public function generateToken($email, $password)
    {
        if ($this->guard->validate(['email.email' => $email, 'password' => $password]) === false) {
            throw new UnauthorizedException('These credentials do not match our records.');
        }

        $user = $this->users->getByEmail(new EmailAddress($email));
        $this->checkUserStatus($user);
        $this->users->save($user->generateApiToken());

        return $user->getApiToken();
    }

    /**
     * @param $email
     * @param $password
     * @return string
     * @throws UnauthorizedException
     */
    public function getToken($email, $password)
    {
        if ($this->guard->validate(['email.email' => $email, 'password' => $password]) === false) {
            throw new UnauthorizedException('These credentials do not match our records.');
        }

        return $this->users->getByEmail(new EmailAddress($email))->getApiToken();
    }
}