<?php namespace Schweppesale\Module\Access\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
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

class AccessServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerRepositories();
        $this->registerBladeExtensions();
        $this->registerFacade();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('access.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'access'
        );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/access');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'access');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'access');
        }
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

    /**
     * Register service provider bindings
     */
    public function registerRepositories()
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepositoryDoctrine::class);
        $this->app->bind(OrganisationRepositoryInterface::class, OrganisationRepositoryDoctrine::class);
        $this->app->bind(PermissionGroupRepositoryInterface::class, PermissionGroupRepositoryDoctrine::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryDoctrine::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepositoryDoctrine::class);
    }

    /**
     * Register the blade extender to use new blade sections
     */
    protected function registerBladeExtensions()
    {
        /**
         * Role based blade extensions
         * Accepts either string of Role Name or Role ID
         */
        Blade::directive('role', function ($role) {
            return "<?php if (access()->hasRole{$role}): ?>";
        });

        /**
         * Accepts array of names or id's
         */
        Blade::directive('roles', function ($roles) {
            return "<?php if (access()->hasRoles{$roles}): ?>";
        });

        Blade::directive('needsroles', function ($roles) {
            return "<?php if (access()->hasRoles(" . $roles . ", true)): ?>";
        });

        /**
         * Permission based blade extensions
         * Accepts wither string of Permission Name or Permission ID
         */
        Blade::directive('permission', function ($permission) {
            return "<?php if (access()->can{$permission}): ?>";
        });

        /**
         * Accepts array of names or id's
         */
        Blade::directive('permissions', function ($permissions) {
            return "<?php if (access()->canMultiple{$permissions}): ?>";
        });

        Blade::directive('needspermissions', function ($permissions) {
            return "<?php if (access()->canMultiple(" . $permissions . ", true)): ?>";
        });

        /**
         * Generic if closer to not interfere with built in blade
         */
        Blade::directive('endauth', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register the vault facade without the user having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Access', \Schweppesale\Module\Access\Application\Services\Facades\Access::class);
        });
    }
}
