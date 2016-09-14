<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Organisation;

/**
 * Interface OrganisationRepository
 *
 * @package App\Repositories\Organisation
 */
interface OrganisationRepository
{

    /**
     * @return Organisation[]
     */
    public function fetchAll();

    /**
     * @param $id
     * @return Organisation
     */
    public function getById($id);

    /**
     * @param Organisation $organisation
     * @return Organisation
     */
    public function save(Organisation $organisation);
}
