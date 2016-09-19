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
    private $parentId;

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
     * @var int[]
     */
    private $permissionIds = [];

    /**
     * GroupDTO constructor.
     * @param $id
     * @param $name
     * @param $order
     * @param $system
     * @param null $parentId
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $order, $system, $parentId = null, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->order = $order;
        $this->system = $system;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \int[]
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
     * @return null|int
     */
    public function getParentId()
    {
        return $this->parentId;
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
            'permissionIds' => $this->permissionIds,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}