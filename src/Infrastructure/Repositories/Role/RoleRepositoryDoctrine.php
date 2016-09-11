<?php
namespace Step\Access\Infrastructure\Repositories\Role;

use Step\Access\Domain\Entities\Role;
use Step\Access\Domain\Entities\User;
use Step\Access\Domain\Repositories\RoleRepository;
use Step\ProjectManagement\Application\Support\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RoleRepositoryDoctrine
 *
 * @package Step\Access\Infrastructure\Repositories\User
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
     * @param $userId
     * @return Role
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
     * @param User $user
     * @return Role
     */
    public function save(Role $role)
    {
        $this->manager->persist($role);
        $this->manager->flush();
        return $role;
    }
}
