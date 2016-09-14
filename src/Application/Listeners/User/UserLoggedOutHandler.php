<?php namespace Schweppesale\Module\Access\Application\Listeners\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Schweppesale\Module\Access\Application\Events\User\UserLoggedOut;

/**
 * Class UserLoggedOutHandler
 *
 * @package Schweppesale\Module\Access\Application\Listeners\User
 */
class UserLoggedOutHandler implements ShouldQueue
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
     * @param  UserLoggedOut $event
     * @return void
     */
    public function handle(UserLoggedOut $event)
    {
        \Log::info("User Logged Out: " . $event->getUser()->getName());
    }
}
