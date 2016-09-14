<?php
namespace Schweppesale\Module\Access\Application\Services\Users;

use Schweppesale\Module\Access\Application\Services\Access;
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
     *
     * @param Access $access
     * @param UserRepository $users
     * @param OrganisationRepository $organisations
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     * @param PermissionGroupRepository $permissionGroups
     * @param AuthenticationService $authenticationService
     */
    public function __construct(
        Access $access,
        MapperInterface $mapper,
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
     * @return User
     */
    public function ban($userId)
    {
        $user = $this->users->getById($userId);
        return $this->users->save($user->ban());
    }

    /**
     * @param $userId
     * @param $password
     * @return User
     * @internal param $currentPassword
     * @internal param $newPassword
     */
    public function changePassword($userId, $password)
    {
        $user = $this->users->getById($userId);
        $user->changePassword($password);

        return $this->users->save($user);
    }

    /**
     * @param $name
     * @param $emailAddress
     * @param $password
     * @param array $roleIds
     * @param array $permissionIds
     * @param bool|false $confirmed
     * @param bool|true $sendConfirmationEmail
     * @param null $status
     * @return User
     */
    public function create($name, $emailAddress, $password, array $roleIds = [], array $permissionIds = [], $confirmed = false, $sendConfirmationEmail = true, $status = null)
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

        return $user;
    }

    /**
     * @return array
     */
    public function createMeta()
    {
        return [
            'roles' => $this->roles->fetchAll(),
            'companies' => $this->organisations->fetchAll(),
            'groups' => $this->permissionGroups->fetchAllParents(),
            'permissions' => $this->permissions->fetchAll()
        ];
    }

    /**
     * @param $userId
     * @return User
     */
    public function deactive($userId)
    {
        $user = $this->users->getById($userId);
        return $this->users->save($user->disable());
    }

    /**
     * @param $userId
     * @param bool|false $softDelete
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
            'user' => $this->users->getById($userId),
            'roles' => $this->roles->fetchAll(),
            'companies' => $this->organisations->fetchAll(),
            'permissions' => $this->permissions->fetchAll(),
            'groups' => $this->permissionGroups->fetchAllParents(),
        ];
    }

    /**
     * @param $userId
     * @return User
     */
    public function enable($userId)
    {
        $user = $this->users->getById($userId);
        return $this->users->save($user->enable());
    }

    /**
     * @return User[]
     */
    public function fetchAll()
    {
        $result = $this->users->fetchAll();

        return array_map(function(User $user) {
            return $this->mapper->map($user, \Schweppesale\Module\Access\Application\Response\User::class);
        }, $result->toArray());
    }

    /**
     * @return User[]
     */
    public function findBanned()
    {
        return $this->users->fetchAllBanned();
    }

    /**
     * @return User[]
     */
    public function findDeactivated()
    {
        return $this->users->fetchAllDeactivated();
    }

    /**
     * @return User[]
     */
    public function findDeleted()
    {
        return $this->users->fetchAllDeleted();
    }

    /**
     * @param $userId
     * @return User
     */
    public function getById($userId)
    {
        return $this->users->getById($userId);
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email)
    {
        return $this->users->getByEmail($email);
    }

    /**
     * @param $userId
     * @param $name
     * @param $email
     * @param array $roleIds
     * @param array $permissionIds
     * @param bool|false $confirmed
     * @param null $status
     * @return User
     */
    public function update($userId, $name, $email, array $roleIds = [], array $permissionIds = [], $confirmed = false, $status = null)
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

        return $this->users->save($user);
    }
}