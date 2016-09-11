<?php
namespace Schweppesale\Access\Application\Database\Seeders\Access;

use Schweppesale\Access\Domain\Repositories\OrganisationRepository;
use Illuminate\Database\Seeder;

/**
 * Class OrganisationTableSeeder
 *
 * @package Schweppesale\Access\Application\Database\Seeders\Access
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
        $organisation = new \Schweppesale\Access\Domain\Entities\Organisation('Alexander Interactive');
        $organisation->setDescription('Company Description');
        $this->organisations->save($organisation);

        $organisation = new \Schweppesale\Access\Domain\Entities\Organisation('Client Company');
        $organisation->setDescription('This is a placeholder');
        $this->organisations->save($organisation);
    }
}
