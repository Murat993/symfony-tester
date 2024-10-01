<?php

namespace App\Model\Quiz\Dto;

use App\Model\Quiz\Entity\Question;

class QuestionResultDTO
{
    private Question $question;
    private bool $isCorrect;
    /** @var AnswerResultDTO[] */
    private array $answers;

    public function __construct(Question $question, bool $isCorrect, array $answers)
    {
        $this->question = $question;
        $this->isCorrect = $isCorrect;
        $this->answers = $answers;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * @return AnswerResultDTO[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }
}