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
     * @var PermissionDTO[]
     */
    private $dependencies;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $system;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @var GroupDTO
     */
    private $group;

    /**
     * Permission constructor.
     * @param $id
     * @param $name
     * @param $displayName
     * @param null|GroupDTO $group
     * @param PermissionDTO[] $dependencies
     * @param $system
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $displayName, $group = null, array $dependencies, $system, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->dependencies = $dependencies;
        $this->displayName = $displayName;
        $this->id = $id;
        $this->name = $name;
        $this->group = $group;
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
     * @return PermissionDTO[]
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
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
     * @return boolean
     */
    public function isSystem(): bool
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
     * @return GroupDTO
     */
    public function getGroup(): GroupDTO
    {
        return $this->group;
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
            'dependencies' => $this->dependencies,
            'group' => $this->getGroup(),
            'system' => $this->system,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}