<?php

namespace Schweppesale\Module\Access\Application\Services\Users;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Exceptions\UnauthorizedException;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Access\Domain\Values\User\Status;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;
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
     * @var Guard
     */
    private $guard;
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var PasswordBroker
     */
    private $passwordBroker;
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * AuthenticationService constructor.
     * @param Guard $guard
     * @param Mailer $mailer
     * @param UserRepository $users
     * @param PasswordBroker $passwordBroker
     * @param MapperInterface $mapper
     */
    public function __construct(
        Guard $guard,
        Mailer $mailer,
        UserRepository $users,
        PasswordBroker $passwordBroker,
        MapperInterface $mapper
    )
    {
        $this->guard = $guard;
        $this->mailer = $mailer;
        $this->users = $users;
        $this->mapper = $mapper;
        $this->passwordBroker = $passwordBroker;
    }

    /**
     * @param $confirmationCode
     * @return User
     */
    public function confirmUser($confirmationCode)
    {
        $user = $this->users->getByConfirmationCode($confirmationCode);
        return $this->users->save($user->confirm());
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        $user = $this->guard->user();
        if (!$user instanceof User) {
            throw new \UnexpectedValueException('User not logged in!');
        }
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $email
     * @param $password
     * @return string
     * @throws UnauthorizedException
     */
    public function generateToken($email, $password)
    {

        dd($this->guard);
        if ($this->guard->validate(['email.email' => $email, 'password' => $password]) === false) {
            throw new UnauthorizedException('These credentials do not match our records.');
        }

        $user = $this->users->getByEmail(new EmailAddress($email));

        if ($user->getStatus() === Status::DISABLED) {
            throw new UnauthorizedException("Your account is currently deactivated.");
        }

        if ($user->getStatus() === Status::BANNED) {
            throw new UnauthorizedException("Your account is currently banned.");
        }

        if ($user->isConfirmed() === false) {
            throw new UnauthorizedException("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user_id) . '">click here</a>' . " to resend the confirmation e-mail.");
        }

        $token = $user->generateToken();
        $this->users->save($user);

        return $token;
    }

    /**
     * @param $token
     * @throws UnauthorizedException
     */
    public function validate($token)
    {
        try {
            $this->guard->setUser($this->users->getByAccessToken($token));
        } catch(EntityNotFoundException $ex) {
            throw new UnauthorizedException('Invalid token', 0, $ex);
        }
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function sendConfirmationEmail($userId)
    {
        $user = $this->users->getById($userId);
        return $this->mailer->send('emails.confirm', ['token' => $user->getConfirmationCode()], function ($message) use ($user) {
            $message->to($user->getEmail(), $user->getName())->subject(app_name() . ': Confirm your account!');
        });
    }

    /**
     * @param $email
     * @return void
     * @throws Exception
     */
    public function sendPasswordResetEmail($email)
    {
        $user = $this->users->getByEmail($email);
        if ($user->isConfirmed() === false) {
            throw new Exception("Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user->getId()) . '">click here</a>' . " to resend the confirmation e-mail.");
        }

        $this->passwordBroker->sendResetLink(['email' => $email], function (Message $message) {
            $message->subject('Your Password Reset Link');
        });
    }
}