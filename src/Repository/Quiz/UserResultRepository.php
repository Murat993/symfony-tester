<?php

declare(strict_types=1);

namespace App\Repository\Quiz;

use App\Model\Quiz\Entity\UserResult;
use App\Model\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<UserResult>
 *
 * @method UserResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserResult[]    findAll()
 * @method UserResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResult::class);
    }

    public function findLatestByUser(User $user): ?UserResult
    {
        return $this->createQueryBuilder('ur')
            ->andWhere('ur.user = :user')
            ->setParameter('user', $user)
            ->orderBy('ur.testTakenAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getLatestByUser(User $user): UserResult
    {
        $userResult = $this->findLatestByUser($user);

        if (!$userResult) {
            throw new \DomainException('User result not found.');
        }

        return $userResult;
    }

    public function add(UserResult $userResult): void
    {
        $this->getEntityManager()->persist($userResult);
    }

}
