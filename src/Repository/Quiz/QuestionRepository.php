<?php

declare(strict_types=1);

namespace App\Repository\Quiz;

use App\Model\Quiz\Entity\Question;
use App\Model\Quiz\Entity\UserAnswer;
use App\Model\Quiz\Entity\UserResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param UserResult $userResult
     * @return Question
     */
    public function findRandomUnansweredQuestion(UserResult $userResult): ?Question
    {
        $answeredQuestionIds = $userResult->getUserAnswers()->map(function(UserAnswer $userAnswer) {
            return $userAnswer->getQuestion()->getId();
        })->toArray();

        $qb = $this->createQueryBuilder('q');
        if (!empty($answeredQuestionIds)) {
            $qb->where('q.id NOT IN (:answeredIds)')
                ->setParameter('answeredIds', array_unique($answeredQuestionIds));
        }

        $qb->orderBy('RANDOM()')
        ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
