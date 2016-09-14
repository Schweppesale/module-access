<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\PermissionGroup;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Schweppesale\Module\Access\Domain\Entities\PermissionGroup;
use Schweppesale\Module\Access\Domain\Repositories\PermissionGroupRepository;

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
     * @return PermissionGroup
     */
    public function getById($id)
    {
        if ($users = $this->manager->getRepository(PermissionGroup::class)->findBy(['id' => $id])) {
            return $users[0];
        } else {
            throw new EntityNotFoundException('Permission Group not found', $id);
        }
    }

    /**
     * @param $name
     * @return PermissionGroup
     */
    public function getByName($name)
    {
        if ($users = $this->manager->getRepository(PermissionGroup::class)->findBy(['name' => $name])) {
            return $users[0];
        } else {
            throw new EntityNotFoundException('Permission Group not found', $name);
        }
    }

    /**
     * @return PermissionGroup[]
     */
    public function fetchAll()
    {
        return $this->manager->getRepository(PermissionGroup::class)->findAll();
    }

    /**
     * @return PermissionGroup[]
     */
    public function fetchAllParents()
    {
        return $this->manager->getRepository(PermissionGroup::class)->findBy(['parent' => null]);
    }

    /**
     * @param PermissionGroup $permissionGroup
     * @return PermissionGroup
     */
    public function save(PermissionGroup $permissionGroup)
    {
        $this->manager->persist($permissionGroup);
        $this->manager->flush();

        return $permissionGroup;
    }
}