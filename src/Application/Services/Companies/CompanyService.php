<?php
namespace Schweppesale\Access\Application\Services\Companies;

use Schweppesale\Access\Domain\Entities\OrganisationLogo;
use Schweppesale\Access\Domain\Repositories\OrganisationRepository;
use Illuminate\Contracts\Filesystem\Factory as FileSystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class CompanyService
 *
 * @package Schweppesale\Access\Application\Services\Companies
 */
class CompanyService
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
     * @param $organisationId
     * @param UploadedFile $uploadedFile
     * @return Company
     */
    public function attachLogo($organisationId, UploadedFile $uploadedFile)
    {
        $organisation = $this->organisations->getCompany($organisationId);
        $logo = CompanyLogo::upload($uploadedFile);
        $organisation->setLogo($logo);
        return $this->organisations->save($organisation);
    }

    /**
     * @param $organisationName
     * @param null $description
     * @return Company
     */
    public function create($organisationName, $description = null)
    {
        $organisation = new Company($organisationName);
        $organisation->setDescription($description);
        return $this->organisations->save($organisation);
    }

    /**
     * @param $organisationid
     * @param $organisationName
     * @param null $description
     * @return Company
     */
    public function update($organisationid, $organisationName, $description = null)
    {
        $organisation = $this->organisations->getCompany($organisationid);
        $organisation->setName($organisationName);
        $organisation->setDescription($description);
        return $this->organisations->save($organisation);
    }
}
