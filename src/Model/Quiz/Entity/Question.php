<?php

declare(strict_types=1);

namespace App\Model\Quiz\Entity;

use App\Repository\Quiz\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'questions')]
class Question
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $text;

    #[ORM\OneToMany(targetEntity: AnswerVariant::class, mappedBy: 'question', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $answerVariants;

    #[ORM\OneToMany(targetEntity: CorrectAnswer::class, mappedBy: 'question', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $correctAnswers;

    #[ORM\OneToMany(targetEntity: UserAnswer::class, mappedBy: 'question', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $userAnswers;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->answerVariants = new ArrayCollection();
        $this->correctAnswers = new ArrayCollection();
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Collection|AnswerVariant[]
     */
    public function getAnswerVariants(): Collection
    {
            return $this->answerVariants;
    }

    /**
     * @return Collection|AnswerVariant[]
     */
    public function getAnswerVariantsShuffle(): Collection
    {
        $variantsArray = $this->answerVariants->toArray();
        shuffle($variantsArray);
        return new ArrayCollection($variantsArray);
    }

    public function addAnswerVariant(AnswerVariant $variant): self
    {
        if (!$this->answerVariants->contains($variant)) {
            $this->answerVariants[] = $variant;
            $variant->setQuestion($this);
        }
        return $this;
    }

    public function removeAnswerVariant(AnswerVariant $variant): self
    {
        if ($this->answerVariants->removeElement($variant)) {
            if ($variant->getQuestion() === $this) {
                $variant->setQuestion(null);
            }
        }
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
            $correctAnswer->setQuestion($this);
        }
        return $this;
    }

    public function removeCorrectAnswer(CorrectAnswer $correctAnswer): self
    {
        if ($this->correctAnswers->removeElement($correctAnswer)) {
            if ($correctAnswer->getQuestion() === $this) {
                $correctAnswer->setQuestion(null);
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
            $userAnswer->setQuestion($this);
        }
        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->removeElement($userAnswer)) {
            if ($userAnswer->getQuestion() === $this) {
                $userAnswer->setQuestion(null);
            }
        }
        return $this;
    }
}
