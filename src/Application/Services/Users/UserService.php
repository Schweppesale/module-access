<?php
namespace Schweppesale\Module\Access\Application\Services\Users;

use Schweppesale\Module\Access\Application\Response\OrganisationDTO;
use Schweppesale\Module\Access\Application\Response\PermissionDTO;
use Schweppesale\Module\Access\Application\Response\PermissionGroupDTO;
use Schweppesale\Module\Access\Application\Response\RoleDTO;
use Schweppesale\Module\Access\Application\Response\UserDTO;
use Schweppesale\Module\Access\Application\Services\Access;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class UserService
 * @package Schweppesale\Module\Access\Application\Services\Users
 */
class UserService
{

    /**
     * @var Access
     */
    private $access;

    /**
     * @var OrganisationRepository
     */
    private $organisations;

    /**
     * @var PermissionGroupRepository
     */
    private $permissionGroups;

    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * UserService constructor.
     * @param MapperInterface $mapper
     * @param Access $access
     * @param UserRepository $users
     * @param OrganisationRepository $organisations
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     * @param PermissionGroupRepository $permissionGroups
     * @param AuthenticationService $authenticationService
     */
    public function __construct(
        MapperInterface $mapper,
        Access $access,
        UserRepository $users,
        OrganisationRepository $organisations,
        RoleRepository $roles,
        PermissionRepository $permissions,
        PermissionGroupRepository $permissionGroups,
        AuthenticationService $authenticationService
    )
    {
        $this->authenticationService = $authenticationService;
        $this->mapper = $mapper;
        $this->access = $access;
        $this->users = $users;
        $this->organisations = $organisations;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->permissionGroups = $permissionGroups;
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function ban($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $user = $this->users->save($user->ban());
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $userId
     * @param $password
     * @return UserDTO
     */
    public function changePassword($userId, $password): UserDTO
    {
        $user = $this->users->getById($userId);
        $user = $this->users->save($user->changePassword($password));
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $name
     * @param $emailAddress
     * @param $password
     * @param array $roleIds
     * @param array $permissionIds
     * @param bool $confirmed
     * @param bool $sendConfirmationEmail
     * @param null $status
     * @return UserDTO
     */
    public function create($name, $emailAddress, $password, array $roleIds = [], array $permissionIds = [], $confirmed = false, $sendConfirmationEmail = true, $status = null): UserDTO
    {
        $status = $status == true ?: User::DISABLED;

        $roles = [];
        foreach ($roleIds as $roleId) {
            $roles[] = $this->roles->getById($roleId);
        }

        $permissions = [];
        if (count($permissionIds) > 0) {
            foreach ($permissionIds as $permissionId) {
                $permissions[] = $this->permissions->getById($permissionId);
            }
        }

        $user = $this->users->save(
            new User(
                $name,
                $emailAddress,
                $password,
                $status,
                $confirmed,
                $permissions,
                $roles
            )
        );

        if ($confirmed == false && $sendConfirmationEmail == true) {
            $this->authenticationService->sendConfirmationEmail($user->getId());
        }

        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @return array
     */
    public function createMeta()
    {
        return [
            'roles' => $this->mapper->mapArray($this->roles->fetchAll()->toArray(), Role::class, RoleDTO::class),
            'organisations' => $this->mapper->mapArray($this->organisations->fetchAll()->toArray(), Organisation::class, OrganisationDTO::class),
            'permissions' => $this->mapper->mapArray($this->permissions->fetchAll()->toArray(), Permission::class, PermissionDTO::class),
            'permissionGroups' => $this->mapper->mapArray($this->permissionGroups->fetchAllParents()->toArray(), PermissionGroup::class, PermissionGroupDTO::class),
        ];
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function deactive($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $this->users->save($user->disable());
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $userId
     * @param bool|false $softDelete
     * @return void
     */
    public function delete($userId, $softDelete = true)
    {
        $this->users->delete($userId, $softDelete);
    }

    /**
     * @param $userId
     * @return array
     */
    public function editMeta($userId)
    {
        return [
            'user' => $this->getById($userId),
            'roles' => $this->roles->fetchAll(),
            'organisations' => $this->organisations->fetchAll(),
            'permissions' => $this->permissions->fetchAll(),
            'permissionGroups' => $this->permissionGroups->fetchAllParents(),
        ];
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function getById($userId) : UserDTO
    {
        $user = $this->users->getById($userId);
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function enable($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $user = $this->users->save($user->enable());
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function fetchAll()
    {
        $result = $this->users->fetchAll();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findBanned()
    {
        $result = $this->users->fetchAllBanned();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findDeactivated()
    {
        $result = $this->users->fetchAllDeactivated();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findDeleted()
    {
        $result = $this->users->fetchAllDeleted();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @param $email
     * @return UserDTO
     */
    public function getByEmail($email): UserDTO
    {
        $user = $this->users->getByEmail($email);
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @param $userId
     * @param $name
     * @param $email
     * @param array $roleIds
     * @param array $permissionIds
     * @param bool $confirmed
     * @param null $status
     * @return UserDTO
     */
    public function update($userId, $name, $email, array $roleIds = [], array $permissionIds = [], $confirmed = false, $status = null): UserDTO
    {
        $user = $this->users->getById($userId);
        $status = $status == true ?: User::DISABLED;

        $userRoles = [];
        foreach ($roleIds as $roleId) {
            $userRoles[] = $this->roles->getById($roleId);
        }

        $permissions = [];
        if (count($permissionIds) > 0) {
            foreach ($permissionIds as $permissionId) {
                $permissions[] = $this->permissions->getById($permissionId);
            }
        }

        $user->setName($name)
            ->setEmail($email)
            ->setRoles($userRoles)
            ->setStatus($status)
            ->setConfirmed($confirmed)
            ->setPermissions($permissions);

        $user = $this->users->save($user);
        return $this->mapper->map($user, UserDTO::class);
    }
}