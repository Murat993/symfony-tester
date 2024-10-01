<?php

declare(strict_types=1);

namespace App\Model\Quiz\Service;


use App\Model\Quiz\Dto\AnswerResultDTO;
use App\Model\Quiz\Dto\QuestionResultDTO;
use App\Model\Quiz\Dto\UserQuestionAnswersDTO;
use App\Model\Quiz\Entity\UserAnswer;
use Doctrine\Common\Collections\Collection;


readonly class QuestionManager
{
    /**
     * @param Collection|UserAnswer[] $userAnswers
     * @return array
     */
    public function prepareQuestionsData(Collection $userAnswers): array
    {
        $userQuestionAnswersList = $this->groupUserAnswersByQuestion($userAnswers);

        $questionsData = [];

        foreach ($userQuestionAnswersList as $userQuestionAnswers) {
            $question = $userQuestionAnswers->getQuestion();
            $userSelectedAnswerVariants = $userQuestionAnswers->getAnswerVariants();

            $correctAnswers = $question->getCorrectAnswers();
            $correctAnswerVariants = array_map(static fn($correctAnswer) => $correctAnswer->getAnswerVariant(), $correctAnswers->toArray());

            // Преобразование в массивы ID для сравнения
            $userAnswerIds = array_map(static fn($entity) => $entity->getId()->toString(), $userSelectedAnswerVariants);
            $correctAnswerIds = array_map(static fn($entity) => $entity->getId()->toString(), $correctAnswerVariants);

            // Проверка на корректность ответа
            $isCorrect = empty(array_diff($userAnswerIds, $correctAnswerIds));

            $answers = [];
            foreach ($question->getAnswerVariants() as $variant) {
                $variantId = $variant->getId()->toString();
                $answers[] = new AnswerResultDTO(
                    $variant,
                    in_array($variantId, $correctAnswerIds, true),
                    in_array($variantId, $userAnswerIds, true)
                );
            }

            $questionsData[] = new QuestionResultDTO($question, $isCorrect, $answers);
        }

        return $questionsData;
    }


    /**
     * @param Collection $userAnswers
     * @return array|UserQuestionAnswersDTO[]
     */
    private function groupUserAnswersByQuestion(Collection $userAnswers): array
    {
        /** @var UserQuestionAnswersDTO[] $grouped */
        $grouped = [];

        foreach ($userAnswers as $userAnswer) {
            $question = $userAnswer->getQuestion();
            $questionId = $question->getId()->toString();

            if (!isset($grouped[$questionId])) {
                $grouped[$questionId] = new UserQuestionAnswersDTO($question);
            }

            if ($userAnswer->getAnswerVariant()) {
                $grouped[$questionId]->addAnswerVariant($userAnswer->getAnswerVariant());
            }
        }

        return array_values($grouped);
    }
}