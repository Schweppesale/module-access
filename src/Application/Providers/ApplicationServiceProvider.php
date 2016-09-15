<?php namespace Schweppesale\Module\Access\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Papper\Papper;
use Schweppesale\Module\Access\Application\Response\OrganisationDTO;
use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Response\PermissionGroupDTO;
use Schweppesale\Module\Access\Application\Response\RoleDTO;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Entities\User;
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
use Schweppesale\Module\Core\Mapper\MapperInterface;
use Schweppesale\Module\Core\Mapper\Papper\Mapper;

class ApplicationServiceProvider extends ServiceProvider
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
        $this->registerConfig();
        $this->registerRepositories();
        $this->registerFacade();
        $this->registerMappings();
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

    public function registerMappings()
    {
        $this->app->bind(MapperInterface::class, Mapper::class);
        $mapper = $this->app->make(MapperInterface::class);

        Papper::createMap(Permission::class, PermissionDTO::class)
            ->constructUsing(function (Permission $permission) use ($mapper) {
                return new PermissionDTO(
                    $permission->getId(),
                    $permission->getName(),
                    $permission->getDisplayName(),
                    array_map(function (Permission $permission) {
                        return $permission->getId();
                    }, $permission->getDependencies()->toArray()),
                    $permission->isSystem(),
                    $permission->getCreatedAt(),
                    $permission->getUpdatedAt()
                );
            });

        Papper::createMap(PermissionGroup::class, PermissionGroupDTO::class)
            ->constructUsing(function (PermissionGroup $permissionGroup) use ($mapper) {
                $parent = $permissionGroup->getParent();
                return new PermissionGroupDTO(
                    $permissionGroup->getId(),
                    $permissionGroup->getName(),
                    $permissionGroup->getSort(),
                    $permissionGroup->getSystem(),
                    ($parent instanceof PermissionGroup) ? $parent->getId() : null,
                    array_map(function (PermissionGroup $permissionGroup) {
                        return $permissionGroup->getId();
                    }, $permissionGroup->getChildren()),
                    $mapper->mapArray($permissionGroup->getPermissions()->toArray(), Permission::class, PermissionDTO::class),
                    $permissionGroup->getCreatedAt(),
                    $permissionGroup->getUpdatedAt()
                );
            });

        Papper::createMap(Organisation::class, OrganisationDTO::class)
            ->constructUsing(function (Organisation $organisation) use ($mapper) {
                return new OrganisationDTO(
                    $organisation->getId(),
                    $organisation->getName(),
                    $organisation->getDescription(),
                    $organisation->getCreatedAt(),
                    $organisation->getUpdatedAt()
                );
            });

        Papper::createMap(Role::class, RoleDTO::class)
            ->constructUsing(function (Role $role) use ($mapper) {
                return new RoleDTO(
                    $role->getId(),
                    $role->getName(),
                    $mapper->mapArray($role->getPermissions()->toArray(), Permission::class, PermissionDTO::class),
                    $role->getAll(),
                    $role->getCreatedAt(),
                    $role->getUpdatedAt()
                );
            });

        Papper::createMap(User::class, UserDTO::class)
            ->constructUsing(function (User $user) use ($mapper) {
                return new UserDTO(
                    $user->getId(),
                    $user->getName(),
                    $user->isConfirmed(),
                    $user->getEmail(),
                    $user->getStatus(),
                    $mapper->mapArray($user->getPermissions()->toArray(), Permission::class, PermissionDTO::class),
                    $mapper->mapArray($user->getRoles()->toArray(), Role::class, RoleDTO::class),
                    $user->getCreatedAt(),
                    $user->getDeletedAt(),
                    $user->getUpdatedAt()
                );
            });
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
