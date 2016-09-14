<?php namespace Schweppesale\Module\Access\Application\Events\User;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Schweppesale\Module\Access\Domain\Entities\User;

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
