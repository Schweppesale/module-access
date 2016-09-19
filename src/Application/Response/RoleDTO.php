<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;
use JsonSerializable;

/**
 * Class RoleDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class RoleDTO implements JsonSerializable
{

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int[]
     */
    private $permissionIds;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Role constructor.
     * @param $id
     * @param $name
     * @param int[] $permissionIds
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, array $permissionIds, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->name = $name;
        $this->permissionIds = $permissionIds;
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
     * @param array $permissionIds
     * @return $this
     */
    public function setPermissionIds(array $permissionIds)
    {
        $this->permissionIds = $permissionIds;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissionIds' => $this->permissionIds,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}