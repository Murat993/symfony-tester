<?php

namespace App\Model\Quiz\Dto;

use App\Model\Quiz\Entity\AnswerVariant;
use App\Model\Quiz\Entity\Question;

class UserQuestionAnswersDTO
{
    private Question $question;
    /** @var AnswerVariant[] */
    private array $answerVariants;

    public function __construct(Question $question, array $answerVariants = [])
    {
        $this->question = $question;
        $this->answerVariants = $answerVariants;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @return AnswerVariant[]
     */
    public function getAnswerVariants(): array
    {
        return $this->answerVariants;
    }

    public function addAnswerVariant(AnswerVariant $answerVariant): void
    {
        $this->answerVariants[] = $answerVariant;
    }
}