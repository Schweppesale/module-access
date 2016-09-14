<?php namespace Schweppesale\Module\Access\Application\Providers;

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
        'Schweppesale\Module\Access\Domain\Events\User\UserLoggedIn' => [
            'Schweppesale\Module\Access\Application\Listeners\User\UserLoggedInHandler',
        ],
        'Schweppesale\Module\Access\Domain\Events\User\UserLoggedOut' => [
            'Schweppesale\Module\Access\Application\Listeners\User\UserLoggedOutHandler',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
