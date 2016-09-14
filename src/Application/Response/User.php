<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;

/**
 * Class User
 * @package Schweppesale\Module\Access\Application\Response
 */
class User
{

    /**
     * @var boolean $confirmed
     */
    private $confirmed;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var DateTime
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
     * @var Permission[]
     */
    private $permissions;

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
     * @param $id
     * @param $name
     * @param $confirmed
     * @param $email
     * @param $status
     * @param array $permissions
     * @param array $roles
     * @param DateTime $createdAt
     * @param DateTime $deletedAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $confirmed, $email, $status, array $permissions, array $roles, DateTime $createdAt, DateTime $deletedAt, DateTime $updatedAt)
    {
        $this->confirmed = $confirmed;
        $this->createdAt = $createdAt;
        $this->deletedAt = $deletedAt;
        $this->email = $email;
        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->status = $status;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return boolean
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getStatus(): int
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
}
