<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\PermissionGroup;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class PermissionGroupRepositoryDoctrine
 *
 * @package Schweppesale\Module\Access\Infrastructure\Repositories\PermissionGroup
 */
class PermissionGroupRepositoryDoctrine implements PermissionGroupRepository
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
        $this->manager = $registry->getManagerForClass(PermissionGroup::class);
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
     * @param $id
     * @return PermissionGroup
     * @throws EntityNotFoundException
     */
    public function getById($id): PermissionGroup
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('pg')
                ->from(PermissionGroup::class, 'pg')
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
     * @return PermissionGroup
     */
    public function getByName($name): PermissionGroup
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('pg')
                ->from(PermissionGroup::class, 'pg')
                ->where('pg.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Permission Group not found!', 0, $ex);
        }
    }

    /**
     * @return PermissionGroup[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('pg')
            ->from(PermissionGroup::class, 'pg')
            ->getQuery()
            ->getResult();
        return new Collection($result);
    }

    /**
     * @return PermissionGroup[]|Collection
     */
    public function findAllParents(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('pg')
            ->from(PermissionGroup::class, 'pg')
            ->where('pg.parent IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function save(PermissionGroup $permissionGroup): PermissionGroup
    {
        $this->manager->persist($permissionGroup);
        $this->manager->flush();

        return $permissionGroup;
    }
}