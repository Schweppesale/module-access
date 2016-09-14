<?php namespace Schweppesale\Module\Access\Application\Events\User;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Schweppesale\Module\Access\Domain\Entities\User;

/**
 * Class UserLoggedOut
 *
 * @package Schweppesale\Module\Access\Application\Events\User
 */
class UserLoggedOut extends Event
{

    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * UserLoggedOut constructor.
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
