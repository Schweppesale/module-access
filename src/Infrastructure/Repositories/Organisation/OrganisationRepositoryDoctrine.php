<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Organisation;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository as OrganisationRepositoryInterface;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class OrganisationRepository
 *
 * @package Schweppesale\Module\Access\Infrastructure\Repositories\Organisation
 */
class OrganisationRepositoryDoctrine implements OrganisationRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserRepositoryDoctrine constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->manager = $registry->getManagerForClass(Organisation::class);
    }

    /**
     * @return Organisation[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('o')
            ->from(Organisation::class, 'o')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param $id
     * @return Organisation
     */
    public function getById($id): Organisation
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('o')
                ->from(Organisation::class, 'o')
                ->where('o.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Organisation not found!', 0, $ex);
        }
    }

    /**
     * @param Organisation $organisation
     * @return Organisation
     */
    public function save(Organisation $organisation): Organisation
    {
        $this->manager->persist($organisation);
        $this->manager->flush();
        return $organisation;
    }
}
