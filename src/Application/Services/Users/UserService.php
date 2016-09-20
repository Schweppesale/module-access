<?php
namespace Schweppesale\Module\Access\Application\Services\Users;

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
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Access\Domain\Services\PasswordHasher;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Access\Domain\Values\Password;
use Schweppesale\Module\Access\Domain\Values\User\Status;
use Schweppesale\Module\Access\Domain\Values\UserStatus;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class UserService
 * @package Schweppesale\Module\Access\Application\Services\Users
 */
class UserService
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;
    /**
     * @var GroupRepository
     */
    private $groups;
    /**
     * @var PasswordHasher
     */
    private $hasher;
    /**
     * @var MapperInterface
     */
    private $mapper;
    /**
     * @var OrganisationRepository
     */
    private $organisations;
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
     * UserService constructor.
     * @param MapperInterface $mapper
     * @param PasswordHasher $hasher
     * @param UserRepository $users
     * @param OrganisationRepository $organisations
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     * @param GroupRepository $groups
     * @param AuthenticationService $authenticationService
     */
    public function __construct(
        MapperInterface $mapper,
        PasswordHasher $hasher,
        UserRepository $users,
        OrganisationRepository $organisations,
        RoleRepository $roles,
        PermissionRepository $permissions,
        GroupRepository $groups,
        AuthenticationService $authenticationService
    )
    {
        $this->hasher = $hasher;
        $this->authenticationService = $authenticationService;
        $this->mapper = $mapper;
        $this->users = $users;
        $this->organisations = $organisations;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->groups = $groups;
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function ban($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $user = $this->users->save($user->updateStatus(Status::banned()));
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
        $status = $status == true ? Status::active() : Status::disabled();

        $roles = array_map(function ($roleId) {
            return $this->roles->getById($roleId);
        }, $roleIds);

        $permissions = array_map(function ($permissionId) {
            return $this->permissions->getById($permissionId);
        }, $permissionIds);

        $user = $this->users->save(
            new User(
                $name,
                new EmailAddress($emailAddress),
                new Password($password, $this->hasher),
                $status,
                $confirmed,
                $permissions,
                $roles
            )
        );

        /**
         * @todo
         */
        if ($confirmed == false && $sendConfirmationEmail == true) {
//            $this->authenticationService->sendConfirmationEmail($user->getId());
        }

        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @return array
     */
    public function createMeta()
    {
        return [
            'roles' => $this->mapper->mapArray($this->roles->findAll()->toArray(), Role::class, RoleDTO::class),
            'organisations' => $this->mapper->mapArray($this->organisations->findAll()->toArray(), Organisation::class, OrganisationDTO::class),
            'permissions' => $this->mapper->mapArray($this->permissions->findAll()->toArray(), Permission::class, PermissionDTO::class),
            'groups' => $this->mapper->mapArray($this->groups->findAllParents()->toArray(), Group::class, GroupDTO::class),
        ];
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function deactive($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $this->users->save($user->updateStatus(Status::disabled()));
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
            'roles' => $this->mapper->mapArray($this->roles->findAll()->toArray(), Role::class, RoleDTO::class),
            'organisations' => $this->mapper->mapArray($this->organisations->findAll()->toArray(), Organisation::class, OrganisationDTO::class),
            'permissions' => $this->mapper->mapArray($this->permissions->findAll()->toArray(), Permission::class, PermissionDTO::class),
            'groups' => $this->mapper->mapArray($this->groups->findAllParents()->toArray(), Group::class, GroupDTO::class),
        ];
    }

    /**
     * @param $userId
     * @return UserDTO
     */
    public function enable($userId): UserDTO
    {
        $user = $this->users->getById($userId);
        $user = $this->users->save($user->updateStatus(Status::active()));
        return $this->mapper->map($user, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findAll()
    {
        $result = $this->users->findAll();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findBanned()
    {
        $result = $this->users->findAllBanned();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @todo inefficient
     *
     * @param $permissionId
     * @return UserDTO[]
     */
    public function findByPermissionId($permissionId)
    {
        $permission = $this->permissions->getById($permissionId);
        $users = $this->users->findAll()->toArray();
        $result = array_filter($users, function (User $user) use ($permission) {
            return $user->can($permission->getName());
        });
        return $this->mapper->mapArray($result, User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findDeactivated()
    {
        $result = $this->users->findAllDeactivated();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @return UserDTO[]
     */
    public function findDeleted()
    {
        $result = $this->users->findAllDeleted();
        return $this->mapper->mapArray($result->toArray(), User::class, UserDTO::class);
    }

    /**
     * @param $email
     * @return UserDTO
     */
    public function getByEmail($email): UserDTO
    {
        $user = $this->users->getByEmail(new EmailAddress($email));
        return $this->mapper->map($user, UserDTO::class);
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
     * @param $name
     * @param $email
     * @param array $roleIds
     * @param array $permissionIds
     * @param bool $confirmed
     * @param null $status
     * @return UserDTO
     */
    public function update($userId, $name, $email, array $roleIds = [], array $permissionIds = [], $status = null): UserDTO
    {
        $user = $this->users->getById($userId);
        $status = $status == true ? Status::active() : Status::disabled();

        $roles = array_map(function ($roleId) {
            return $this->roles->getById($roleId);
        }, $roleIds);

        $permissions = array_map(function ($permissionId) {
            return $this->permissions->getById($permissionId);
        }, $permissionIds);

        $user->setName($name)
            ->setRoles($roles)
            ->setPermissions($permissions)
            ->updateStatus($status)
            ->updateEmail(new EmailAddress($email));

        $user = $this->users->save($user);
        return $this->mapper->map($user, UserDTO::class);
    }
}