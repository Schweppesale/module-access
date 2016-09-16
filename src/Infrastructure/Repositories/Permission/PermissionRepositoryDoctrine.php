<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Permission;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class PermissionRepositoryDoctrine
 *
 * @package Schweppesale\Module\Access\Infrastructure\Repositories\Permission
 */
class PermissionRepositoryDoctrine implements PermissionRepository
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
        $this->manager = $registry->getManagerForClass(Permission::class);
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
     * @return Permission
     * @throws EntityNotFoundException
     */
    public function getById($id): Permission
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('p')
                ->from(Permission::class, 'p')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Permission not found!', 0, $ex);
        }
    }

    /**
     * @return Permission[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('p')
            ->from(Permission::class, 'p')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function save(Permission $permission): Permission
    {
        if ($this->manager->contains($permission) === false) {
            $this->manager->persist($permission);
        }
        $this->manager->flush();
        return $permission;
    }
}