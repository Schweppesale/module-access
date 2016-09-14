<?php namespace Schweppesale\Module\Access\Presentation\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Module;
use Nwidart\Modules\Repository;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository as OrganisationRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository as PermissionGroupRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository as PermissionRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository as RoleRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository as UserRepositoryInterface;
use Schweppesale\Module\Access\Infrastructure\Repositories\Organisation\OrganisationRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\Permission\PermissionRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\PermissionGroup\PermissionGroupRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\Role\RoleRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\User\UserRepositoryDoctrine;

class PresentationServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var Module
     */
    private $module;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
