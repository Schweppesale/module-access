<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;
use JsonSerializable;

/**
 * Class PermissionDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class PermissionDTO implements JsonSerializable
{

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var int[]
     */
    private $dependencyIds;

    /**
     * @var string
     */
    private $displayName;
    /**
     * @var int|null
     */
    private $groupId;
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
    private $roleIds;
    /**
     * @var bool
     */
    private $system;
    /**
     * @var DateTime
     */
    private $updatedAt;
    /**
     * @var int[]
     */
    private $userIds;

    /**
     * PermissionDTO constructor.
     * @param $id
     * @param $name
     * @param $displayName
     * @param $system
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $displayName, $system, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->displayName = $displayName;
        $this->id = $id;
        $this->name = $name;
        $this->system = $system;
        $this->updatedAt = $updatedAt;
        $this->dependencyIds = $this->groupId = $this->userIds = $this->roleIds = [];
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int[]
     */
    public function getDependencyIds(): array
    {
        return $this->dependencyIds;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->groupId;
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
     * @return array
     */
    public function getRoleIds(): array
    {
        return $this->roleIds;
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
    public function getUserIds(): array
    {
        return $this->userIds;
    }

    /**
     * @return boolean
     */
    public function isSystem(): bool
    {
        return $this->system;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'displayName' => $this->displayName,
            'dependencyIds' => $this->dependencyIds,
            'groupId' => $this->getGroupId(),
            'userIds' => $this->userIds,
            'roleIds' => $this->roleIds,
            'system' => $this->system,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }

    /**
     * @param array $dependencyIds
     * @return $this
     */
    public function setDependencyIds(array $dependencyIds)
    {
        $this->dependencyIds = $dependencyIds;

        return $this;
    }

    /**
     * @param int|null $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @param array $roleIds
     * @return $this
     */
    public function setRoleIds(array $roleIds)
    {
        $this->roleIds = $roleIds;

        return $this;
    }

    /**
     * @param array $userIds
     * @return $this
     */
    public function setUserIds(array $userIds)
    {
        $this->userIds = $userIds;

        return $this;
    }
}