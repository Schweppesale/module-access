<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;
use JsonSerializable;

/**
 * Class GroupDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class GroupDTO implements JsonSerializable
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
     * @var mixed
     */
    private $parent;

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
     * GroupDTO constructor.
     * @param $id
     * @param $name
     * @param $order
     * @param $system
     * @param null|GroupDTO $parent
     * @param array $permissions
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $order, $system, GroupDTO $parent = null, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
        $this->order = $order;
        $this->system = $system;
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
     * @return null|GroupDTO
     */
    public function getParent()
    {
        return $this->parent;
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
            'parent' => $this->parent,
            'permissions' => $this->permissions,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}