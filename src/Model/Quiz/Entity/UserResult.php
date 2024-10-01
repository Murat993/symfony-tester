<?php

declare(strict_types=1);

namespace App\Model\Quiz\Entity;

use App\Model\Quiz\Enums\TestStatus;
use App\Model\User\Entity\User;
use App\Repository\Quiz\UserResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserResultRepository::class)]
#[ORM\Table(name: 'user_results')]
class UserResult
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userResults')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: 'integer')]
    private int $try;

    #[ORM\Column(type: 'string', length: 10)]
    private string $status;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $testTakenAt;

    #[ORM\OneToMany(targetEntity: UserAnswer::class, mappedBy: 'userResult', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $userAnswers;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->status = TestStatus::PROCESS->value;
        $this->testTakenAt = new \DateTimeImmutable();
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getTry(): int
    {
        return $this->try;
    }

    public function setTry(int $try): self
    {
        $this->try = $try;
        return $this;
    }

    public function getStatus(): TestStatus
    {
        return TestStatus::from($this->status);
    }

    public function setStatus(TestStatus $status): self
    {
        $this->status = $status->value;
        return $this;
    }

    public function getTestTakenAt(): \DateTimeInterface
    {
        return $this->testTakenAt;
    }

    public function setTestTakenAt(\DateTimeInterface $testTakenAt): self
    {
        $this->testTakenAt = $testTakenAt;
        return $this;
    }

    /**
     * @return Collection|UserAnswer[]
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): self
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->add($userAnswer);
            $userAnswer->setUserResult($this);
        }
        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->removeElement($userAnswer)) {
            if ($userAnswer->getUserResult() === $this) {
                $userAnswer->setUserResult(null);
            }
        }
        return $this;
    }
}
