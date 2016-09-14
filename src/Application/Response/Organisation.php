<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;

/**
 * Class Organisation
 * @package Schweppesale\Module\Access\Application\Response
 */
class Organisation{


    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * Organisation constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     */
    public function __construct($id, $name, $description, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->description = $description;
        $this->id = $id;
        $this->name = $name;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}