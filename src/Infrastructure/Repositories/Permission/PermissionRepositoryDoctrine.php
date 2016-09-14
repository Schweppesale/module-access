<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\Permission;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Schweppesale\Module\Access\Domain\Entities\Permission;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroup\PermissionGroup;
use Schweppesale\Module\Access\Domain\Repositories\PermissionRepository;

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