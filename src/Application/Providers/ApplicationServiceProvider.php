<?php namespace Schweppesale\Module\Access\Application\Providers;

use Papper\Papper;
use Schweppesale\Module\Access\Application\Response\GroupDTO;
use Schweppesale\Module\Access\Application\Response\OrganisationDTO;
use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Response\RoleDTO;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository as GroupRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository as OrganisationRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository as PermissionRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository as RoleRepositoryInterface;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository as UserRepositoryInterface;
use Schweppesale\Module\Access\Infrastructure\Repositories\Group\GroupRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\Organisation\OrganisationRepositoryDoctrine;
use Schweppesale\Module\Access\Infrastructure\Repositories\Permission\PermissionRepositoryDoctrine;
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
        $this->app->bind(GroupRepositoryInterface::class, GroupRepositoryDoctrine::class);
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

        Papper::createMap(Group::class, GroupDTO::class)
            ->ignoreAllNonExisting()
            ->constructUsing(function (Group $group) {
                $parent = $group->getParent();
                $parentId = ($parent) ? $parent->getId() : null;
                return new GroupDTO(
                    $group->getId(),
                    $group->getName(),
                    $group->getSort(),
                    $group->getSystem(),
                    $parentId,
                    $group->getCreatedAt(),
                    $group->getUpdatedAt()
                );
            });

        Papper::createMap(Permission::class, PermissionDTO::class)
            ->ignoreAllNonExisting()
            ->constructUsing(function (Permission $permission) {
                return new PermissionDTO(
                    $permission->getId(),
                    $permission->getName(),
                    $permission->getDisplayName(),
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
            ->ignoreAllNonExisting()
            ->constructUsing(function (Role $role) {
                $permissions = $role->getPermissions()->toArray();
                $permissionIds = array_map(function (Permission $permission) {
                    return $permission->getId();
                }, $permissions);

                return new RoleDTO(
                    $role->getId(),
                    $role->getName(),
                    $permissionIds,
                    $role->getCreatedAt(),
                    $role->getUpdatedAt()
                );
            });

        Papper::createMap(User::class, UserDTO::class)
            ->constructUsing(function (User $user) {

                $permissions = $user->getPermissions()->toArray();
                $permissionIds = array_map(function (Permission $permission) {
                    return $permission->getId();
                }, $permissions);

                $roles = $user->getRoles()->toArray();
                $roleIds = array_map(function (Role $role) {
                    return $role->getId();
                }, $roles);

                return new UserDTO(
                    $user->getId(),
                    $user->getName(),
                    $user->isConfirmed(),
                    $user->getEmail(),
                    $user->getStatus(),
                    $permissionIds,
                    $roleIds,
                    $user->getCreatedAt(),
                    $user->getDeletedAt(),
                    $user->getUpdatedAt()
                );
            });
    }
}
