<?php
namespace Schweppesale\Module\Access\Infrastructure\Repositories\User;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Schweppesale\Module\Access\Domain\Entities\User;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;
use Schweppesale\Module\Access\Domain\Values\EmailAddress;
use Schweppesale\Module\Access\Domain\Values\User\Status;
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
     * @return User[]|Collection
     */
    public function findAll(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status.status = ' . Status::ACTIVE)
            ->andWhere('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]|Collection
     */
    public function findAllBanned(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status.status = ' . Status::BANNED)
            ->andWhere('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]|Collection
     */
    public function findAllDeactivated(): Collection
    {
        $result = $this->manager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.status.status = ' . Status::DISABLED)
            ->andWhere('u.deletedAt IS NULL')
            ->getQuery()
            ->getResult();

        return new Collection($result);
    }

    /**
     * @return User[]|Collection
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
     * @todo implementation
     *
     * @param $permissionId
     * @return User[]|Collection
     */
    public function findByPermissionId($permissionId): Collection
    {

    }

    /**
     * @param string $code
     * @return User
     * @throws EntityNotFoundException
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

    /**
     * @param EmailAddress $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByEmail(EmailAddress $email): User
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u')
                ->where('u.email.email = :email')
                ->setParameter('email', $email->value())
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('User not found!', 0, $ex);
        }
    }

    public function getByAccessToken($token): User
    {
        try {

            return $this->manager->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u')
                ->where('u.accessToken = :token')
                ->setParameter('token', $token)
                ->getQuery()
                ->getSingleResult();

        } catch (NoResultException $ex) {
            throw new EntityNotFoundException('User not found!', 0, $ex);
        }
    }

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
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
}
