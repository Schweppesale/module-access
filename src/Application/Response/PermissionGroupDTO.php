<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;

/**
 * Class PermissionGroupDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class PermissionGroupDTO implements \JsonSerializable
{

    /**
     * @var PermissionGroupDTO[]
     */
    private $children;

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
     * @var mixed
     */
    private $parentId;

    /**
     * @var RoleDTO[]
     */
    private $permissions;

    /**
     * @var int
     */
    private $order;

    /**
     * @var int
     */
    private $system;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * PermissionGroupDTO constructor.
     * @param $id
     * @param $name
     * @param $order
     * @param $system
     * @param int $parentId
     * @param array $children
     * @param array $permissions
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $order, $system, $parentId = null, array $children, array $permissions, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->children = $children;
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->permissions = $permissions;
        $this->order = $order;
        $this->system = $system;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return PermissionGroupDTO[]
     */
    public function getChildren(): array
    {
        return $this->children;
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
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @return RoleDTO[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getSystem(): int
    {
        return $this->system;
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
            'order' => $this->order,
            'system' => $this->system,
            'parentId' => $this->parentId,
            'children' => $this->children,
            'permissions' => $this->permissions,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}