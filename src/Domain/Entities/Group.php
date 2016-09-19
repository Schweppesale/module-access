<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Group
 *
 * @package Schweppesale\Domain\Entities
 */
class Group
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
     * @var Group
     */
    private $parent;

    /**
     * @var int
     */
    private $sort;

    /**
     * @var int
     */
    private $system;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Group constructor.
     *
     * @param $name
     * @param bool|false $system
     * @param Group|null $parent
     */
    public function __construct($name, bool $system = false, Group $parent = null)
    {
        $this->name = $name;
        $this->system = $system;
        $this->parent = $parent;
        $this->sort = 0;

        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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
     * @return Group|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return bool
     */
    public function getSystem(): bool
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
     * @param $name
     * @return $this
     */
    public function setName($name): Group
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $sort
     * @return $this
     */
    public function setSort($sort): Group
    {
        $this->sort = $sort;

        return $this;
    }
}
