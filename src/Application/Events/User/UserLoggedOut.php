<?php namespace Step\Access\Application\Events\User;

use Step\Access\Domain\Entities\User;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserLoggedOut
 *
 * @package Step\Access\Application\Events\User
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
