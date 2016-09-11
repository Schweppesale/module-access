<?php
namespace Schweppesale\Access\Domain\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Organisation as OrganisationContract;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;


/**
 * Class Company
 *
 * @package Modules\Peggy\Entities
 *
 * @ORM\Entity
 * @ORM\Table(name="companies")
 * @HasLifecycleCallbacks
 */
class Organisation implements \JsonSerializable, OrganisationContract
{

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var CompanyLogo
     * @OneToOne(targetEntity="\Schweppesale\Access\Domain\Entities\OrganisationLogo", cascade={"all"}, orphanRemoval=true, fetch="EAGER")
     * @JoinColumn(name="logo_image_id", referencedColumnName="id")
     */
    private $logo;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $logo_image_id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return CompanyLogo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param CompanyLogo $logo
     */
    public function setLogo(OrganisationLogo $logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return int
     */
    public function getLogoImageId()
    {
        return $this->logo_image_id;
    }

    /**
     * @param int $logo_image_id
     */
    public function setLogoImageId($logo_image_id)
    {
        $this->logo_image_id = $logo_image_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @PreUpdate
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }
}
