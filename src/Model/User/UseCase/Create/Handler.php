<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Create;

use App\Model\User\Entity\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class Handler
{
    public function __construct(
        private UserRepository         $userRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function handle(Command $command): void
    {
        if (!$this->userRepository->findOneBy(['username' => $command->username])) {
            $user = new User($command->username);
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}
