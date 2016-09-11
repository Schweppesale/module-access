<?php namespace Step\Access\Application\Listeners\User;

use Step\Access\Application\Events\User\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class UserLoggedInHandler
 *
 * @package Step\Access\Application\Listeners\User
 */
class UserLoggedInHandler implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedIn $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        \Log::info("User Logged In: " . $event->getUser()->getName());
    }
}
