<?php

declare(strict_types=1);


namespace App\Model\Quiz\UseCase\Start;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank(message="ID вопроса не должно быть пустым.")
     * @Assert\Uuid(message="Неверный формат UUID для ID вопроса.")
     */
    public Uuid $id;

}
