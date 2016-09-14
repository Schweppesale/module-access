<?php
namespace Schweppesale\Module\Access\Application\Services\Organisations;

use Illuminate\Contracts\Filesystem\Factory as FileSystem;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;

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
     * @var FileSystem
     */
    private $fileSystem;

    /**
     * @param OrganisationRepository $organisations
     * @param FileSystem $fileSystem
     */
    public function __construct(OrganisationRepository $organisations, FileSystem $fileSystem)
    {
        $this->organisations = $organisations;
        $this->fileSystem = $fileSystem;
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
        return $this->organisations->save($organisation);
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
        return $this->organisations->save($organisation);
    }
}
