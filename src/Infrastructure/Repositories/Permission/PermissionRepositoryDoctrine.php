<?php
namespace Step\Access\Infrastructure\Repositories\Permission;

use Step\Access\Domain\Entities\Permission;
use Step\Access\Domain\Repositories\PermissionGroup\PermissionGroup;
use Step\Access\Domain\Repositories\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\EntityNotFoundException;

/**
 * Class PermissionRepositoryDoctrine
 *
 * @package Step\Access\Infrastructure\Repositories\Permission
 */
class PermissionRepositoryDoctrine implements PermissionRepository
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $this->manager->remove($this->getById($id));
        return true;
    }

    /**
     * @param $id
     * @return Permission
     */
    public function getById($id)
    {
        if ($permissions = $this->manager->getRepository(Permission::class)->findBy(['id' => $id])) {
            return $permissions[0];
        } else {
            throw new EntityNotFoundException('Permission not found', $id);
        }
    }

    /**
     * @return Permission[]
     */
    public function fetchAll()
    {
        return $this->manager->getRepository(Permission::class)->findAll();
    }

    /**
     * @param Permission $permission
     * @return Permission
     */
    public function save(Permission $permission)
    {
        if ($this->manager->contains($permission) === false) {
            $this->manager->persist($permission);
        }
        $this->manager->flush();
        return $permission;
    }
}