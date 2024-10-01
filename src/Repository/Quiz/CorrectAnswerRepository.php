<?php

declare(strict_types=1);

namespace App\Repository\Quiz;

use App\Model\Quiz\Entity\CorrectAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CorrectAnswer>
 *
 * @method CorrectAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CorrectAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CorrectAnswer[]    findAll()
 * @method CorrectAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorrectAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorrectAnswer::class);
    }
}
