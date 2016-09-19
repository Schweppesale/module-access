<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Group;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class GroupRepositoryDoctrine
 *
 * @package Schweppesale\Module\Access\Infrastructure\Repositories\Group
 */
class GroupRepositoryDoctrine implements GroupRepository
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
        $this->manager = $registry->getManagerForClass(Group::class);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $this->manager->remove($this->getById($id));
        return true;
    }

    /**
     * @return Group[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('pg')
            ->from(Group::class, 'pg')
            ->getQuery()
            ->getResult();
        return new Collection($result);
    }

    /**
     * @return Group[]|Collection
     */
    public function findAllParents(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('pg')
            ->from(Group::class, 'pg')
            ->where('pg.parent IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param $id
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getById($id): Group
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('pg')
                ->from(Group::class, 'pg')
                ->where('pg.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Permission Group not found!', 0, $ex);
        }
    }

    /**
     * @param $name
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getByName($name): Group
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('pg')
                ->from(Group::class, 'pg')
                ->where('pg.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Permission Group not found!', 0, $ex);
        }
    }

    /**
     * @param Group $group
     * @return Group
     */
    public function save(Group $group): Group
    {
        $this->manager->persist($group);
        $this->manager->flush();

        return $group;
    }
}