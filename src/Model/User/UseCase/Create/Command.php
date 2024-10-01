<?php

declare(strict_types=1);


namespace App\Model\User\UseCase\Create;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public string $username;
}
