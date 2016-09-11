<?php
namespace Step\Access\Application\Database\Seeders\Access;

use Step\Access\Domain\Repositories\OrganisationRepository;
use Illuminate\Database\Seeder;

/**
 * Class OrganisationTableSeeder
 *
 * @package Step\Access\Application\Database\Seeders\Access
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
        $organisation = new \Step\Access\Domain\Entities\Organisation('Alexander Interactive');
        $organisation->setDescription('Company Description');
        $this->organisations->save($organisation);

        $organisation = new \Step\Access\Domain\Entities\Organisation('Client Company');
        $organisation->setDescription('This is a placeholder');
        $this->organisations->save($organisation);
    }
}
