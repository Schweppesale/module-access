<?php
namespace Schweppesale\Module\Access\Domain\Repositories;

use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Core\Collections\Collection;

/**
 * Interface OrganisationRepository
 *
 * @package App\Repositories\Organisation
 */
interface OrganisationRepository
{

    /**
     * @return Organisation[]|Collection
     */
    public function findAll(): Collection;

    /**
     * @param $id
     * @return Organisation
     */
    public function getById($id): Organisation;

    /**
     * @param Organisation $organisation
     * @return Organisation
     */
    public function save(Organisation $organisation): Organisation;
}
