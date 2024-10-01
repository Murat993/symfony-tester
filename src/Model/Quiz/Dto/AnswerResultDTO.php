<?php

namespace App\Model\Quiz\Dto;

use App\Model\Quiz\Entity\AnswerVariant;

class AnswerResultDTO
{
    private AnswerVariant $answerVariant;
    private bool $isCorrect;
    private bool $isSelected;

    public function __construct(AnswerVariant $answerVariant, bool $isCorrect, bool $isSelected)
    {
        $this->answerVariant = $answerVariant;
        $this->isCorrect = $isCorrect;
        $this->isSelected = $isSelected;
    }

    public function getAnswerVariant(): AnswerVariant
    {
        return $this->answerVariant;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function isSelected(): bool
    {
        return $this->isSelected;
    }
}