<?php
namespace Schweppesale\Access\Infrastructure\Repositories\User;

use Schweppesale\Access\Domain\Entities\User;
use Schweppesale\Access\Domain\Repositories\UserRepository;
use Schweppesale\ProjectManagement\Application\Support\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

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
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $userId
     * @param bool|true $softDelete
     * @return bool
     */
    public function delete($userId, $softDelete = true)
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
     * @return User[]
     */
    public function fetchAll()
    {
        $query = $this->manager->createQueryBuilder();
        $query->select('u');
        $query->from(User::class, 'u');
        $query->where('u.status = ' . User::ACTIVE . ' AND u.deletedAt IS NULL');

        return new Collection($query->getQuery()->getResult());
    }

    /**
     * @return User[]
     */
    public function fetchAllBanned()
    {
        $query = $this->manager->createQueryBuilder();
        $query->select('u');
        $query->from(User::class, 'u');
        $query->where('u.status = ' . User::BANNED . ' AND u.deletedAt IS NULL');

        return new Collection($query->getQuery()->getResult());
    }

    /**
     * @return User[]
     */
    public function fetchAllDeactivated()
    {
        $query = $this->manager->createQueryBuilder();
        $query->select('u');
        $query->from(User::class, 'u');
        $query->where('u.status = ' . User::DISABLED . ' AND u.deletedAt IS NULL');

        return new Collection($query->getQuery()->getResult());
    }

    /**
     * @return User[]
     */
    public function fetchAllDeleted()
    {
        $query = $this->manager->createQueryBuilder();
        $query->select('u');
        $query->from(User::class, 'u');
        $query->where('u.deletedAt IS NOT NULL');

        return new Collection($query->getQuery()->getResult());
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById($id)
    {
        if ($users = $this->manager->getRepository(User::class)->findBy(['id' => $id])) {
            return $users[0];
        } else {
            throw new \Illuminate\Contracts\Queue\EntityNotFoundException('User not found', $id);
        }
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmail($email)
    {
        if ($users = $this->manager->getRepository(User::class)->findBy(['email' => $email])) {
            return $users[0];
        } else {
            throw new \Illuminate\Contracts\Queue\EntityNotFoundException('User not found', $email);
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function findUserById($id)
    {
        if ($users = $this->manager->getRepository(User::class)->findBy(['id' => $id])) {
            return $users[0];
        }
        return false;
    }

    /**
     * @param string $token
     * @return User
     */
    public function getByToken($token)
    {
        if ($users = $this->manager->getRepository(User::class)->findBy(['confirmationCode' => $token])) {
            return $users[0];
        } else {
            throw new \Illuminate\Contracts\Queue\EntityNotFoundException('User not found', $token);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        $this->manager->persist($user);
        $this->manager->flush();
        return $user;
    }
}
