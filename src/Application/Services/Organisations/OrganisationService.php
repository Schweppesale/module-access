<?php
namespace Schweppesale\Module\Access\Application\Services\Organisations;

use Illuminate\Contracts\Filesystem\Factory as FileSystem;
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
     * @var OrganisationRepository
     */
    private $organisations;

    /**
     * @var MapperInterface
     */
    private $mapper;

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
     * @return Organisation
     */
    public function create($organisationName, $description = null)
    {
        $organisation = new Organisation($organisationName);
        $organisation->setDescription($description);
        $organisation = $this->organisations->save($organisation);

        return $this->mapper->map($organisation, OrganisationDTO::class);
    }

    /**
     * @param $organisationid
     * @param $organisationName
     * @param null $description
     * @return Organisation
     */
    public function update($organisationid, $organisationName, $description = null)
    {
        $organisation = $this->organisations->getById($organisationid);
        $organisation->setName($organisationName);
        $organisation->setDescription($description);
        $organisation = $this->organisations->save($organisation);

        return $this->mapper->map($organisation, OrganisationDTO::class);
    }
}
