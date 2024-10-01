<?php

declare(strict_types=1);

namespace App\Model\Quiz\UseCase\Start;

use App\Model\Quiz\Entity\CorrectAnswer;
use App\Model\Quiz\Entity\UserResult;
use App\Repository\Quiz\UserResultRepository;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class Handler
{
    public function __construct(
        private UserRepository         $userRepository,
        private UserResultRepository   $userResultRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function handle(Command $command): void
    {
        $user = $this->userRepository->find($command->id);

        /** @var CorrectAnswer|null $testResult */
        $latestUserResult = $this->userResultRepository->findLatestByUser($user);

        if ($latestUserResult && $latestUserResult->getStatus()->isProcess()) {
            return;
        }

        $tryCount = $latestUserResult ? $latestUserResult->getTry() : 0;

        $userResult = new UserResult();
        $userResult->setUser($user);
        $userResult->setTry($tryCount + 1);

        $this->userResultRepository->add($userResult);

        $this->em->flush();
    }
}
