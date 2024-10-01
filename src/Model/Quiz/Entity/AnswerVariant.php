<?php

declare(strict_types=1);

namespace App\Model\Quiz\Entity;

use App\Repository\Quiz\AnswerVariantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AnswerVariantRepository::class)]
#[ORM\Table(name: 'answer_variants')]
class AnswerVariant
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'answerVariants')]
    #[ORM\JoinColumn(nullable: false)]
    private Question $question;

    #[ORM\Column(type: 'string', length: 255)]
    private string $variant;

    #[ORM\OneToMany(targetEntity: CorrectAnswer::class, mappedBy: 'answerVariant', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $correctAnswers;

    #[ORM\OneToMany(targetEntity: UserAnswer::class, mappedBy: 'answerVariant', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $userAnswers;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->correctAnswers = new ArrayCollection();
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getVariant(): string
    {
        return $this->variant;
    }

    public function setVariant(string $variant): self
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * @return Collection|CorrectAnswer[]
     */
    public function getCorrectAnswers(): Collection
    {
        return $this->correctAnswers;
    }

    public function addCorrectAnswer(CorrectAnswer $correctAnswer): self
    {
        if (!$this->correctAnswers->contains($correctAnswer)) {
            $this->correctAnswers[] = $correctAnswer;
            $correctAnswer->setAnswerVariant($this);
        }
        return $this;
    }

    public function removeCorrectAnswer(CorrectAnswer $correctAnswer): self
    {
        if ($this->correctAnswers->removeElement($correctAnswer)) {
            if ($correctAnswer->getAnswerVariant() === $this) {
                $correctAnswer->setAnswerVariant(null);
            }
        }
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
            $this->userAnswers[] = $userAnswer;
            $userAnswer->setAnswerVariant($this);
        }
        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->removeElement($userAnswer)) {
            if ($userAnswer->getAnswerVariant() === $this) {
                $userAnswer->setAnswerVariant(null);
            }
        }
        return $this;
    }
}
