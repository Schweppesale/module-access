<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Role;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class RoleRepositoryDoctrine
 *
 * @package Schweppesale\Module\Access\Infrastructure\Repositories\User
 */
class RoleRepositoryDoctrine implements RoleRepository
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
        $this->manager = $registry->getManagerForClass(Role::class);
    }

    /**
     * @return Role[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('r')
            ->from(Role::class, 'r')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $this->manager->remove($this->getById($id));
        $this->manager->flush();
        return true;
    }

    /**
     * @param $id
     * @return Role
     * @throws EntityNotFoundException
     */
    public function getById($id): Role
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('r')
                ->from(Role::class, 'r')
                ->where('r.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Role not found!', 0, $ex);
        }
    }

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role): Role
    {
        $this->manager->persist($role);
        $this->manager->flush();
        return $role;
    }
}
