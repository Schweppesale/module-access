<?php
namespace Step\Access\Infrastructure\Repositories\PermissionDependency;

use Step\Access\Domain\Entities\PermissionDependency;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\EntityNotFoundException;

/**
 * Class PermissionDependencyRepositoryDoctrine
 *
 * @package Step\Access\Infrastructure\Repositories\PermissionDependency
 */
class PermissionDependencyRepositoryDoctrine implements PermissionDependencyRepository
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
     * @return PermissionDependency
     */
    public function getById($id)
    {
        if ($users = $this->manager->getRepository(PermissionDependency::class)->findBy(['id' => $id])) {
            return $users[0];
        } else {
            throw new EntityNotFoundException('Permission Dependency not found', $id);
        }
    }
}