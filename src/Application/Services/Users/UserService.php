<?php
namespace Step\Access\Application\Services\Users;

use Step\Access\Application\Services\Access;
use Step\Access\Domain\Entities\User;
use Step\Access\Domain\Repositories\OrganisationRepository;
use Step\Access\Domain\Repositories\PermissionGroup\PermissionGroupInterface;
use Step\Access\Domain\Repositories\PermissionGroup\PermissionInterface;
use Step\Access\Domain\Repositories\PermissionGroupRepository;
use Step\Access\Domain\Repositories\PermissionRepository;
use Step\Access\Domain\Repositories\RoleRepository;
use Step\Access\Domain\Repositories\UserRepository;

/**
 * Class UserService
 *
 * @package Step\Access\Application\Services\Users
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
     * @var PermissionGroupInterface
     */
    private $permissionGroups;

    /**
     * @var PermissionInterface
     */
    private $permissions;

    /**
     * @var RoleRepositoryContract
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
        UserRepository $users,
        OrganisationRepository $organisations,
        RoleRepository $roles,
        PermissionRepository $permissions,
        PermissionGroupRepository $permissionGroups,
        AuthenticationService $authenticationService
    )
    {
        $this->authenticationService = $authenticationService;
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
     * @param $currentPassword
     * @param $newPassword
     * @return User
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
     * @return \Step\Access\Domain\Entities\User[]
     */
    public function fetchAll()
    {
        return $this->users->fetchAll();
    }

    /**
     * @return \Step\Access\Domain\Entities\User[]
     */
    public function findBanned()
    {
        return $this->users->fetchAllBanned();
    }

    /**
     * @return \Step\Access\Domain\Entities\User[]
     */
    public function findDeactivated()
    {
        return $this->users->fetchAllDeactivated();
    }

    /**
     * @return \Step\Access\Domain\Entities\User[]
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