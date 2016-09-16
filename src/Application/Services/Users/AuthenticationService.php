<?php

namespace Schweppesale\Module\Access\Application\Services\Users;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Events\User\UserLoggedIn;
use Schweppesale\Module\Access\Domain\Events\User\UserLoggedOut;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Core\Exceptions\Exception;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class AuthenticationService
 *
 * @package Schweppesale\Module\Access\Application\Services\Users
 */
class AuthenticationService
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var PasswordBroker
     */
    private $passwordBroker;

    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * AuthenticationService constructor.
     * @param Guard $auth
     * @param UserRepository $users
     * @param PasswordBroker $passwordBroker
     * @param MapperInterface $mapper
     */
    public function __construct(
        Guard $auth,
        UserRepository $users,
        PasswordBroker $passwordBroker,
        MapperInterface $mapper
    )
    {
        $this->auth = $auth;
        $this->users = $users;
        $this->mapper = $mapper;
        $this->passwordBroker = $passwordBroker;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function sendConfirmationEmail($userId)
    {
        $user = $this->users->getById($userId);
        return Mail::send('emails.confirm', ['token' => $user->getConfirmationCode()], function ($message) use ($user) {
            $message->to($user->getEmail(), $user->getName())->subject(app_name() . ': Confirm your account!');
        });
    }

    /**
     * @param $token
     * @return User
     */
    public function confirmUser($token)
    {
        $user = $this->users->getByToken($token);
        return $this->users->save($user->setConfirmed(true));
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function login($email, $password)
    {
        if ($this->auth->attempt(['email' => $email, 'password' => $password])) {

            $user = $this->getUser();

            if ($user->getStatus() === User::DISABLED) {
                $this->auth->logout();
                throw new Exception("Your account is currently deactivated.");
            }

            if ($user->getStatus() === User::BANNED) {
                $this->auth->logout();
                throw new Exception("Your account is currently banned.");
            }

            if ($user->isConfirmed() === false) {
                $user_id = $user->getId();
                $this->auth->logout();
                throw new Exception("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user_id) . '">click here</a>' . " to resend the confirmation e-mail.");
            }

            event(new UserLoggedIn($user));
            return true;

        }

        throw new Exception('These credentials do not match our records.');
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        $user = $this->auth->user();
        if (!$user instanceof User) {
            throw new \UnexpectedValueException('User not logged in!');
        }
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * Log the user out and fire an event
     */
    public function logout()
    {
        event(new UserLoggedOut($this->getUser()));
        $this->auth->logout();
    }

    /**
     * @param $email
     * @return void
     * @throws Exception
     */
    public function sendPasswordResetEmail($email)
    {
        //Make sure user is confirmed before resetting password.
        $user = $this->users->getByEmail($email);

        if ($user) {
            if ($user->isConfirmed() === false) {
                throw new Exception("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user->getId()) . '">click here</a>' . " to resend the confirmation e-mail.");
            }
        } else {
            throw new Exception("There is no user with that e-mail address.");
        }

        $this->passwordBroker->sendResetLink(['email' => $email], function (Message $message) {
            $message->subject('Your Password Reset Link');
        });
    }
}