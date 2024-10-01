<?php

namespace App\Model\Quiz\Enums;

enum TestStatus: string
{
    case PROCESS = 'process';
    case FINISH = 'finish';


    public function isProcess(): bool
    {
        return $this === self::PROCESS;
    }

    public function isFinish(): bool
    {
        return $this === self::FINISH;
    }
}