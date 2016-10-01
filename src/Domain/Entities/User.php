<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Illuminate\Contracts\Auth\Authenticatable;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsInterface;
use LaravelDoctrine\ACL\Mappings as ACL;
use Schweppesale\Module\Access\Domain\Entities\Traits\CanBeAuthenticated;
use Schweppesale\Module\Access\Domain\Exceptions\UnauthorizedException;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Access\Domain\Values\HashedPassword;
use Schweppesale\Module\Access\Domain\Values\Password;
use Schweppesale\Module\Access\Domain\Values\User\Status;

/**
 * Class User
 *
 * @package Schweppesale\Domain\Entities
 */
class User implements HasPermissionsInterface, Authenticatable
{

    use CanBeAuthenticated;

    /**
     * @var string
     */
    private $api_token;
    /**
     * @var string $confirmation_code
     */
    private $confirmationCode;
    /**
     * @var boolean $confirmed
     */
    private $confirmed;
    /**
     * @var DateTime
     */
    private $createdAt;
    /**
     * @var mixed
     */
    private $deletedAt;
    /**
     * @var EmailAddress $email
     */
    private $email;
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $id
     */
    private $name;
    /**
     * @var HashedPassword $password
     */
    private $password;
    /**
     * @var Permission[]
     */
    private $permissions;
    /**
     * @var string $remember_token
     */
    private $rememberToken;
    /**
     * @var Role[]
     */
    private $roles;
    /**
     * @var Status $status
     */
    private $status;
    /**
     * @var DateTime $updated_at
     */
    private $updatedAt;

    /**
     * User constructor.
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $status
     * @param $confirmed
     * @param $permissions
     * @param $roles
     */
    public function __construct($name, EmailAddress $email, Password $password, Status $status, bool $confirmed, $permissions, $roles)
    {
        $this->name = $name;
        $this->confirmed = $confirmed;
        $this->createdAt = new DateTime();
        $this->confirmed = $confirmed;

        if ($this->confirmationCode === null) {
            $this->confirmationCode = md5(uniqid(mt_rand(), true));
        }

        $this->updateEmail($email);
        $this->setUpdatedAt(new DateTime());
        $this->changePassword($password);
        $this->updateStatus($status);
        $this->setPermissions($permissions);
        $this->setRoles($roles);
    }

    /**
     * @param Permission $permission
     * @return $this
     */
    public function addPermission(Permission $permission): User
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function addRole(Role $role): User
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function can($permission): bool
    {
        foreach ($this->getRoles() as $role) {
            if ($role->can($permission) === true) {
                return true;
            }
        }
        return $this->hasPermissionTo($permission);
    }

    /**
     * @param array $permissions
     * @param bool|false $strict
     * @return bool
     */
    public function canMultiple(array $permissions, $strict = true): bool
    {
        $ourPermissions = $this->getPermissions()->map(function (Role $role) {
            return $role->getName();
        })->toArray();

        if ($strict === true) {
            return count(array_intersect($permissions, $ourPermissions)) == count($roles);
        } else {
            return count(array_intersect($permissions, $ourPermissions)) > 0;
        }
    }

    /**
     * @param Password $password
     * @return $this
     */
    public function changePassword(Password $password)
    {
        $this->password = $password->hash();

        return $this;
    }

    /**
     * @return $this
     */
    public function confirm(): User
    {
        $this->confirmed = true;

        return $this;
    }

    /**
     * @return User
     */
    public function destroyApiToken(): User
    {
        $this->api_token = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function generateApiToken(): User
    {
        $this->api_token = md5(uniqid(mt_rand(), true));
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiToken()
    {
        return $this->api_token;
    }

    /**
     * @return EmailAddress
     */
    public function getAuthIdentifierName(): EmailAddress
    {
        return $this->getEmail();
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->rememberToken;
    }

    /**
     * @param $rememberToken
     * @return $this
     */
    public function setRememberToken($rememberToken): User
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationCode(): string
    {
        return $this->confirmationCode;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return EmailAddress
     */
    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailForPasswordReset(): EmailAddress
    {
        return $this->getEmail();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return HashedPassword
     */
    public function getPassword(): HashedPassword
    {
        return $this->password;
    }

    /**
     * @return Permission[]|Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        return $this->can($permission);
    }

    /**
     * @return Role[]|Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRole(string $name): bool
    {
        foreach ($this->getRoles() as $role) {
            if ($role->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $roles
     * @param bool|true $strict
     * @return bool
     */
    public function hasRoles(array $roles, $strict = true): bool
    {
        $ourRoles = $this->getRoles()->map(function (Role $role) {
            return $role->getName();
        })->toArray();

        if ($strict === true) {
            return count(array_intersect($roles, $ourRoles)) == count($roles);
        } else {
            return count(array_intersect($roles, $ourRoles)) > 0;
        }
    }

    /**
     * @return boolean
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @return $this
     */
    public function markAsDeleted(): User
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

    /**
     * @param $permission
     * @throws UnauthorizedException
     */
    public function must($permission)
    {
        if ($this->can($permission) === false) {
            throw new UnauthorizedException('Unauthorized');
        }
    }

    /**
     * @PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Permission[] $permissions
     * @return $this
     */
    public function setPermissions(array $permissions): User
    {
        $this->permissions = [];

        array_map([$this, 'addPermission'], $permissions);

        return $this;
    }

    /**
     * @param Role[] $roles
     * @return $this
     */
    public function setRoles(array $roles): User
    {
        $this->roles = [];

        array_map([$this, 'addRole'], $roles);

        return $this;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    protected function setUpdatedAt(DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param EmailAddress $email
     * @return $this
     */
    public function updateEmail(EmailAddress $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param Status $status
     * @return $this
     */
    public function updateStatus(Status $status): User
    {
        $this->status = $status;

        return $this;
    }
}
