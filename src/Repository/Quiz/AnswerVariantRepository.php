<?php

declare(strict_types=1);

namespace App\Repository\Quiz;

use App\Model\Quiz\Entity\AnswerVariant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnswerVariant>
 *
 * @method AnswerVariant|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerVariant|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerVariant[]    findAll()
 * @method AnswerVariant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerVariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerVariant::class);
    }
}
