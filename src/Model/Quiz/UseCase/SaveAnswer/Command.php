<?php

declare(strict_types=1);


namespace App\Model\Quiz\UseCase\SaveAnswer;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(string $userResultId, string $questionId)
    {
        $this->userResultId = $userResultId;
        $this->questionId = $questionId;
    }

    #[Assert\NotBlank(message: 'Выберите хотя бы один вариант ответа.')]
    #[Assert\All(
        constraints: [
            new Assert\Uuid(message: 'Неверный формат UUID для варианта ответа.')
        ]
    )]
    public array $answerVariantIds = [];

    #[Assert\NotBlank(message: 'ID вопроса не должно быть пустым.')]
    #[Assert\Uuid(message: 'Неверный формат UUID для ID вопроса.')]
    public string  $userResultId;

    #[Assert\NotBlank(message: 'ID вопроса не должно быть пустым.')]
    #[Assert\Uuid(message: 'Неверный формат UUID для ID вопроса.')]
    public string  $questionId;
}
