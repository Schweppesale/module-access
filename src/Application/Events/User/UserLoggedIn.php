<?php namespace Step\Access\Application\Events\User;

use Step\Access\Domain\Entities\User;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserLoggedIn
 *
 * @package Step\Access\Application\Events\User
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
