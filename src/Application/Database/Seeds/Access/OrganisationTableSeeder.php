<?php
namespace Schweppesale\Module\Access\Application\Database\Seeds\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;

/**
 * Class OrganisationTableSeeder
 *
 * @package Schweppesale\Module\Access\Application\Database\Seeds\Access
 */
class OrganisationTableSeeder extends Seeder
{

    /**
     * @var OrganisationRepository
     */
    private $organisations;

    /**
     * @param OrganisationRepository $organisations
     */
    public function __construct(OrganisationRepository $organisations)
    {
        $this->organisations = $organisations;
    }

    /**
     * @return void
     */
    public function run()
    {
        $organisation = new Organisation('Company Name');
        $organisation->setDescription('Description');
        $this->organisations->save($organisation);

        $organisation = new Organisation('Client Organisation');
        $organisation->setDescription('Description');
        $this->organisations->save($organisation);
    }
}
