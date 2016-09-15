<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Role;

use Doctrine\ORM\EntityManagerInterface;
use Schweppesale\Module\Access\Domain\Entities\Role;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Core\Collections\Collection;

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
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Role[]
     */
    public function fetchAll()
    {
        return new Collection($this->manager->getRepository(Role::class)->findAll());
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $this->manager->remove($this->getById($id));
        $this->manager->flush();
        return true;
    }

    /**
     * @param $id
     * @return Role
     * @internal param $userId
     */
    public function getById($id)
    {
        if ($roles = $this->manager->getRepository(Role::class)->findBy(['id' => $id])) {
            return $roles[0];
        } else {
            throw new \Illuminate\Contracts\Queue\EntityNotFoundException('Role not found', $id);
        }
    }

    /**
     * @param Role $role
     * @return Role
     * @internal param User $user
     */
    public function save(Role $role)
    {
        $this->manager->persist($role);
        $this->manager->flush();
        return $role;
    }
}
