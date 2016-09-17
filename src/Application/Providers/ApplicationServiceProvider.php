<?php namespace Schweppesale\Module\Access\Application\Providers;

use Papper\MemberOption\Ignore;
use Papper\MemberOptionInterface;
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
use Schweppesale\Module\Core\Providers\Laravel\ServiceProvider;

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

        $this->mergeConfigRecursiveFrom(
            __DIR__ . '/../Config/doctrine.php', 'doctrine'
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
    }

    public function registerMappings()
    {
        $this->app->singleton(MapperInterface::class, Mapper::class);

        Papper::createMap(PermissionGroup::class, PermissionGroupDTO::class)
            ->constructUsing(function(PermissionGroup $permissionGroup) {
                $parent = $permissionGroup->getParent();
                $permissions = $permissionGroup->getPermissions();

                return new PermissionGroupDTO(
                    $permissionGroup->getId(),
                    $permissionGroup->getName(),
                    $permissionGroup->getSort(),
                    $permissionGroup->getSystem(),
                    null,
//                    $parent != false ? Papper::map($parent)->toType(PermissionGroupDTO::class) : null,
                    $permissionGroup->getCreatedAt(),
                    $permissionGroup->getUpdatedAt()
                );
            });

        Papper::createMap(Permission::class, PermissionDTO::class)
            ->constructUsing(function (Permission $permission) {
                $group = $permission->getPermissionGroup();
                $dependencies = $permission->getDependencies();

                return new PermissionDTO(
                    $permission->getId(),
                    $permission->getName(),
                    $permission->getDisplayName(),
                    ($group) ? Papper::map($group, PermissionGroup::class)->toType(PermissionGroupDTO::class) : null,
                    ($dependencies) ? Papper::map($dependencies->toArray(), Permission::class)->toType(PermissionDTO::class) : [],
                    $permission->isSystem(),
                    $permission->getCreatedAt(),
                    $permission->getUpdatedAt()
                );
            });

        Papper::createMap(Organisation::class, OrganisationDTO::class)
            ->constructUsing(function (Organisation $organisation) {
                return new OrganisationDTO(
                    $organisation->getId(),
                    $organisation->getName(),
                    $organisation->getDescription(),
                    $organisation->getCreatedAt(),
                    $organisation->getUpdatedAt()
                );
            });

        Papper::createMap(Role::class, RoleDTO::class)
            ->constructUsing(function (Role $role) {
                return new RoleDTO(
                    $role->getId(),
                    $role->getName(),
                    Papper::map($role->getPermissions()->toArray(), Permission::class)->toType(PermissionDTO::class),
                    $role->getCreatedAt(),
                    $role->getUpdatedAt()
                );
            });

        Papper::createMap(User::class, UserDTO::class)
            ->constructUsing(function (User $user) {
                return new UserDTO(
                    $user->getId(),
                    $user->getName(),
                    $user->isConfirmed(),
                    $user->getEmail(),
                    $user->getStatus(),
                    Papper::map($user->getPermissions()->toArray(), Permission::class)->toType(PermissionDTO::class),
                    Papper::map($user->getRoles()->toArray(), Role::class)->toType(RoleDTO::class),
                    $user->getCreatedAt(),
                    $user->getDeletedAt(),
                    $user->getUpdatedAt()
                );
            });
    }
}
