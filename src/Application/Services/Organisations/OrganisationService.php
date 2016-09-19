<?php
namespace Schweppesale\Module\Access\Application\Services\Organisations;

use Schweppesale\Module\Access\Application\Response\OrganisationDTO;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;
use Schweppesale\Module\Core\Mapper\MapperInterface;

/**
 * Class OrganisationService
 *
 * @package Schweppesale\Module\Access\Application\Services\Organisations
 */
class OrganisationService
{

    /**
     * @var MapperInterface
     */
    private $mapper;
    /**
     * @var OrganisationRepository
     */
    private $organisations;

    /**
     * OrganisationService constructor.
     * @param MapperInterface $mapper
     * @param OrganisationRepository $organisations
     */
    public function __construct(MapperInterface $mapper, OrganisationRepository $organisations)
    {
        $this->mapper = $mapper;
        $this->organisations = $organisations;
    }

    /**
     * @param $organisationName
     * @param null $description
     * @return OrganisationDTO
     */
    public function create($organisationName, $description = null): OrganisationDTO
    {
        $organisation = new Organisation($organisationName);
        $organisation->setDescription($description);
        $organisation = $this->organisations->save($organisation);

        return $this->mapper->map($organisation, OrganisationDTO::class);
    }

    /**
     * @return OrganisationDTO[]
     */
    public function findAll()
    {
        return $this->mapper->mapArray($this->organisations->findAll()->toArray(), Organisation::class, OrganisationDTO::class);
    }

    /**
     * @param $organisationId
     * @return OrganisationDTO
     */
    public function getById($organisationId): OrganisationDTO
    {
        return $this->mapper->map($this->organisations->getById($organisationId), OrganisationDTO::class);
    }

    /**
     * @param $organisationId
     * @param $organisationName
     * @param null $description
     * @return OrganisationDTO
     */
    public function update($organisationId, $organisationName, $description = null): OrganisationDTO
    {
        $organisation = $this->organisations->getById($organisationId);
        $organisation->setName($organisationName);
        $organisation->setDescription($description);
        $organisation = $this->organisations->save($organisation);

        return $this->mapper->map($organisation, OrganisationDTO::class);
    }
}
