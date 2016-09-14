<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;

/**
 * Class Role
 * @package Schweppesale\Module\Access\Application\Response
 */
class Role{

    /**
     * @var int
     */
    private $all;

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
     * @var Permission[]
     */
    private $permissions;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Role constructor.
     * @param $id
     * @param $name
     * @param array $permissions
     * @param $all
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, array $permissions, $all, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->all = $all;
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getAll(): int
    {
        return $this->all;
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
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}