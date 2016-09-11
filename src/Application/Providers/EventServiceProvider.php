<?php namespace Schweppesale\Access\Application\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /**
         * Frontend Events
         */
        'Schweppesale\Access\Application\Events\User\UserLoggedIn' => [
            'Schweppesale\Access\Application\Listeners\User\UserLoggedInHandler',
        ],
        'Schweppesale\Access\Application\Events\User\UserLoggedOut' => [
            'Schweppesale\Access\Application\Listeners\User\UserLoggedOutHandler',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
