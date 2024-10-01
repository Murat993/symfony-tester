<?php

declare(strict_types=1);

namespace App\Model\Quiz\UseCase\SaveAnswer;

use App\Model\Quiz\Entity\Question;
use App\Model\Quiz\Entity\UserAnswer;
use App\Model\Quiz\Entity\UserResult;
use App\Model\Quiz\Enums\TestStatus;
use App\Repository\Quiz\AnswerVariantRepository;
use App\Repository\Quiz\QuestionRepository;
use App\Repository\Quiz\UserResultRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class Handler
{
    public function __construct(
        private AnswerVariantRepository $answerVariantRepository,
        private UserResultRepository    $userResultRepository,
        private QuestionRepository      $questionRepository,
        private EntityManagerInterface  $em
    ) {
    }

    public function handle(Command $command): void
    {
        /** @var UserResult $userResult */
        $userResult = $this->userResultRepository->find($command->userResultId);
        $question = $this->questionRepository->find($command->questionId);

        foreach ($command->answerVariantIds as $answerVariantId) {
            $userAnswer = new UserAnswer();
            $userAnswer->setUserResult($userResult);
            $userAnswer->setQuestion($question);
            $userAnswer->setAnswerVariant($this->answerVariantRepository->find($answerVariantId));
            $userResult->addUserAnswer($userAnswer);
        }


        if (!$this->questionRepository->findRandomUnansweredQuestion($userResult)) {
            $userResult->setStatus(TestStatus::FINISH);
            $this->em->persist($userResult);
        }

        $this->em->flush();
    }
}
