<?php namespace Schweppesale\Module\Access\Application\Listeners\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Schweppesale\Module\Access\Domain\Events\User\UserLoggedIn;

/**
 * Class UserLoggedInHandler
 *
 * @package Schweppesale\Module\Access\Application\Listeners\User
 */
class UserLoggedInHandler implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Create the event handler.
     *
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
