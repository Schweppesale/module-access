<?php
namespace Schweppesale\Module\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use LaravelDoctrine\ACL\Contracts\Organisation as OrganisationContract;


/**
 * Class Organisation
 *
 * @package Schweppesale\Domain\Entities
 */
class Organisation implements OrganisationContract
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
     * @param $name
     */
    public function __construct($name)
    {
        $this->setName($name);
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
     * @PreUpdate
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @param string $description
     */
    public function setDescription($description): Organisation
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $name
     */
    public function setName($name): Organisation
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param DateTime|int $updatedAt
     */
    protected function setUpdatedAt(DateTime $updatedAt): Organisation
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
