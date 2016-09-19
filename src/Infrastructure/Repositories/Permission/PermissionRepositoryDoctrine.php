<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Permission;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Schweppesale\Module\Access\Domain\Entities\Group;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Repositories\GroupRepository;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
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
     * @var GroupRepository
     */
    private $groups;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var RoleRepository
     */
    private $roles;
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * PermissionRepositoryDoctrine constructor.
     * @param ManagerRegistry $registry
     * @param RoleRepository $roles
     * @param UserRepository $users
     * @param GroupRepository $groups
     */
    public function __construct(
        ManagerRegistry $registry,
        RoleRepository $roles,
        UserRepository $users,
        GroupRepository $groups
    )
    {
        $this->manager = $registry->getManagerForClass(Permission::class);
        $this->roles = $roles;
        $this->users = $users;
        $this->groups = $groups;
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

    public function findByGroupId($groupId): Collection
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $result = $qb->select('p')
                ->from(Permission::class, 'p')
                ->join(Group::class, 'g', Join::INNER_JOIN, $qb->expr()->eq('(p.group)', ':groupId'))
                ->setParameter('groupId', $groupId)
                ->getQuery()
                ->getResult();

            return new Collection($result);

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('Group not found!', 0, $ex);
        }
    }

    /**
     * @param $roleId
     * @return Permission[]|Collection
     */
    public function findByRoleId($roleId): Collection
    {
        return new Collection($this->roles->getById($roleId)->getPermissions()->toArray());
    }

    /**
     * @param $userId
     * @return Permission[]|Collection
     */
    public function findByUserId($userId): Collection
    {
        return new Collection($this->users->getById($userId)->getPermissions()->toArray());
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