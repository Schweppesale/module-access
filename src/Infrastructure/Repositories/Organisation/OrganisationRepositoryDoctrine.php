<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Organisation;

use Doctrine\ORM\EntityManagerInterface;
use Schweppesale\Module\Access\Domain\Entities\Organisation;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository as OrganisationRepositoryInterface;

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
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Organisation[]
     */
    public function fetchAll()
    {
        return $this->entityManager->getRepository(Organisation::class)->findAll();
    }

    /**
     * @param $id
     * @return Organisation
     */
    public function getById($id)
    {
        return $this->entityManager->find(Organisation::class, $id);
    }

    /**
     * @param Organisation $organisation
     * @return Organisation
     */
    public function save(Organisation $organisation)
    {
        $this->entityManager->persist($organisation);
        $this->entityManager->flush();
        return $organisation;
    }
}
