<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\User;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Core\Collections\Collection;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepositoryDoctrine implements UserRepository
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
        $this->manager = $registry->getManagerForClass(User::class);
    }

    /**
     * @param $userId
     * @param bool|true $softDelete
     * @return bool
     */
    public function delete($userId, $softDelete = true): bool
    {
        $user = $this->getById($userId);
        if ($softDelete === true) {
            $this->save($user->markAsDeleted());
        } else {
            $this->manager->remove($user);
            $this->manager->flush();
        }
        return true;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById($id): User
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u')
                ->where('u.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('User not found!', 0, $ex);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $this->manager->persist($user);
        $this->manager->flush();
        return $user;
    }

    /**
     * @return User[]
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status = ' . User::ACTIVE)
            ->where('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]
     */
    public function findAllBanned(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status = ' . User::BANNED)
            ->where('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]
     */
    public function findAllDeactivated(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status = ' . User::DISABLED)
            ->where('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]
     */
    public function findAllDeleted(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.deletedAt IS NOT NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email): User
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u')
                ->where('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('User not found!', 0, $ex);
        }
    }

    /**
     * @param string $token
     * @return User
     */
    public function getByConfirmationCode($code): User
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u')
                ->where('u.confirmationCode = :confirmationCode')
                ->setParameter('confirmationCode', $code)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('User not found!', 0, $ex);
        }
    }
}
