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

/**
 * Class User
 *
 * @package Schweppesale\Domain\Entities
 */
class User implements HasPermissionsInterface, Authenticatable
{

    const ACTIVE = 0x01;

    const BANNED = 0x02;

    const DISABLED = 0x00;

    use CanBeAuthenticated;

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
     * @var string $email
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
     * @var string $password
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
     * @var int $status
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
    public function __construct($name, $email, $password, $status, $confirmed, $permissions, $roles)
    {
        $this->name = $name;
        $this->email = $email;
        $this->confirmed = $confirmed;

        if ($this->confirmationCode === null) {
            $this->confirmationCode = md5(uniqid(mt_rand(), true));
        }

        $this->setUpdatedAt(new DateTime());
        $this->setCreatedAt(new DateTime());
        $this->setConfirmed($confirmed);
        $this->changePassword($password);
        $this->setStatus($status);
        $this->setPermissions($permissions);
        $this->setRoles($roles);
    }

    /**
     * @param $password
     * @return $this
     */
    public function changePassword($password)
    {
        $this->password = bcrypt($password);

        return $this;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->can($permission);
    }

    /**
     * @param $permission
     * @return bool
     */
    public function can($permission)
    {
        foreach ($this->getRoles() as $role) {
            if ($role->can($permission) === true) {
                return true;
            }
        }
        return $this->hasPermissionTo($permission);
    }

    /**
     * @return Role[]|Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role[] $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        foreach ($roles as $role) {
            if (!$role instanceof Role) {
                throw new \InvalidArgumentException('Invalid Role Type');
            }
        }

        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getEmail();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return $this
     */
    public function ban()
    {
        $this->status = self::BANNED;
        return $this;
    }

    /**
     * @return $this
     */
    public function disable()
    {
        $this->status = self::DISABLED;

        return $this;
    }

    /**
     * @return $this
     */
    public function enable()
    {
        $this->status = self::ACTIVE;

        $this->deletedAt = null;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->getEmail();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param array $permissions
     * @param bool|false $strict
     * @return bool
     */
    public function canMultiple(array $permissions, $strict = true)
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
     * @return Permission[]|Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param Permission[] $permissions
     * @return $this
     */
    public function setPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$permission instanceof Permission) {
                throw new \InvalidArgumentException('Invalid Permission Type');
            }
        }

        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        foreach ($this->getRoles() as $ourRole) {
            if ($ourRole->getName() === $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $roles
     * @param bool|true $strict
     * @return bool
     */
    public function hasRoles($roles, $strict = true)
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
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param $rememberToken
     * @return $this
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationCode()
    {
        return $this->confirmationCode;
    }

    /**
     * @param $confirmationCode
     * @return $this
     */
    public function setConfirmationCode($confirmationCode)
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param $confirmed
     * @return $this
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime $deletedAt
     * @return $this
     */
    public function setDeletedAt(DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function markAsDeleted()
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

    /**
     * @PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }
}
