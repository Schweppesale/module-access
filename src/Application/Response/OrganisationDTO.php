<?php
namespace Schweppesale\Module\Access\Application\Response;

use DateTime;

/**
 * Class OrganisationDTO
 * @package Schweppesale\Module\Access\Application\Response
 */
class OrganisationDTO implements \JsonSerializable
{


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

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}