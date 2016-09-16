<?php namespace Schweppesale\Module\Access\Application\Events\User;

use Illuminate\Queue\SerializesModels;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Core\Events\Event;

/**
 * Class UserLoggedIn
 *
 * @package Schweppesale\Module\Access\Application\Events\User
 */
class UserLoggedIn extends Event
{

    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * UserLoggedIn constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}