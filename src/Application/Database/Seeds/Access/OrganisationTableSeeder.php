<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
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
        $organisation = new \Schweppesale\Module\Access\Domain\Entities\Organisation('Alexander Interactive');
        $organisation->setDescription('Organisation Description');
        $this->organisations->save($organisation);

        $organisation = new \Schweppesale\Module\Access\Domain\Entities\Organisation('Client Organisation');
        $organisation->setDescription('This is a placeholder');
        $this->organisations->save($organisation);
    }
}
