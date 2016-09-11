<?php
namespace Step\Access\Infrastructure\Repositories\Organisation;

use Step\Access\Domain\Entities\Organisation;
use Step\Access\Domain\Repositories\OrganisationRepository as OrganisationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrganisationRepository
 *
 * @package Step\Access\Infrastructure\Repositories\Organisation
 */
class OrganisationRepositoryDoctrine implements OrganisationRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Company[]
     */
    public function fetchAll()
    {
        return $this->entityManager->getRepository(Organisation::class)->findAll();
    }

    /**
     * @param $id
     * @return Company
     */
    public function getById($id)
    {
        return $this->entityManager->find(Organisation::class, $id);
    }

    /**
     * @param Company $organisation
     * @return Company
     */
    public function save(Organisation $organisation)
    {
        $this->entityManager->persist($organisation);
        $this->entityManager->flush();
        return $organisation;
    }
}
