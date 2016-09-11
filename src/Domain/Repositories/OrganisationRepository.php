<?php
namespace Step\Access\Domain\Repositories;

use Step\Access\Domain\Entities\Organisation;

/**
 * Interface OrganisationRepository
 *
 * @package App\Repositories\Organisation
 */
interface OrganisationRepository
{

    /**
     * @return Company[]
     */
    public function fetchAll();

    /**
     * @param $id
     * @return Company
     */
    public function getById($id);

    /**
     * @param Company $organisation
     * @return Company
     */
    public function save(Organisation $organisation);
}
