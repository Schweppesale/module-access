<?php

namespace Schweppesale\Module\Access\Application\Services\Users;

use Schweppesale\Module\Core\Exceptions\GeneralException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Schweppesale\Module\Access\Domain\Events\User\UserLoggedIn;
use Schweppesale\Module\Access\Domain\Events\User\UserLoggedOut;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;

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
     * AuthenticationService constructor.
     *
     * @param Guard $auth
     * @param UserRepository $users
     * @param PasswordBroker $passwordBroker
     */
    public function __construct(
        Guard $auth,
        UserRepository $users,
        PasswordBroker $passwordBroker
    )
    {
        $this->auth = $auth;
        $this->users = $users;
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
     * @throws GeneralException
     */
    public function login($email, $password)
    {
        if ($this->auth->attempt(['email' => $email, 'password' => $password])) {

            $user = $this->getUser();

            if ($user->getStatus() === User::DISABLED) {
                $this->auth->logout();
                throw new GeneralException("Your account is currently deactivated.");
            }

            if ($user->getStatus() === User::BANNED) {
                $this->auth->logout();
                throw new GeneralException("Your account is currently banned.");
            }

            if ($user->isConfirmed() === false) {
                $user_id = $user->getId();
                $this->auth->logout();
                throw new GeneralException("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user_id) . '">click here</a>' . " to resend the confirmation e-mail.");
            }

            event(new UserLoggedIn($user));
            return true;

        }

        throw new GeneralException('These credentials do not match our records.');
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = $this->auth->user();
        if (!$user instanceof User) {
            throw new \UnexpectedValueException('Invalid User Entity');
        }
        return $user;
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
     * @return $this|\Illuminate\Http\RedirectResponse|string
     * @throws GeneralException
     */
    public function sendPasswordResetEmail($email)
    {
        //Make sure user is confirmed before resetting password.
        $user = $this->users->getByEmail($email);

        if ($user) {
            if ($user->isConfirmed() === false) {
                throw new GeneralException("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user->getId()) . '">click here</a>' . " to resend the confirmation e-mail.");
            }
        } else {
            throw new GeneralException("There is no user with that e-mail address.");
        }

        return $this->passwordBroker->sendResetLink(['email' => $email], function (Message $message) {
            $message->subject('Your Password Reset Link');
        });
    }
}