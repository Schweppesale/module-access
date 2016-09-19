<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;
use JsonSerializable;

/**
 * Class UserDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class UserDTO implements JsonSerializable
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
     * @var int[]
     */
    private $permissionIds;

    /**
     * @var int[]
     */
    private $roleIds;

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
     * @param int[] $permissionIds
     * @param int[] $roleIds
     * @param DateTime $createdAt
     * @param mixed $deletedAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $confirmed, $email, $status, array $permissionIds, array $roleIds, DateTime $createdAt, $deletedAt, DateTime $updatedAt)
    {
        $this->confirmed = $confirmed;
        $this->createdAt = $createdAt;
        $this->deletedAt = $deletedAt;
        $this->email = $email;
        $this->id = $id;
        $this->name = $name;
        $this->permissionIds = $permissionIds;
        $this->roleIds = $roleIds;
        $this->status = $status;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
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
     * @return int[]
     */
    public function getPermissionIds(): array
    {
        return $this->permissionIds;
    }

    /**
     * @return int[]
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
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

    /**
     * @return boolean
     */
    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'emailAddress' => $this->email,
            'status' => $this->status,
            'confirmed' => $this->confirmed,
            'roleIds' => $this->roleIds,
            'permissionIds' => $this->permissionIds,
            'createdAt' => $this->createdAt,
            'deletedAt' => $this->deletedAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
