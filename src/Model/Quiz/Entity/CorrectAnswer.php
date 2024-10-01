<?php

declare(strict_types=1);

namespace App\Model\Quiz\Entity;

use App\Repository\Quiz\CorrectAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CorrectAnswerRepository::class)]
#[ORM\Table(name: 'correct_answers')]
class CorrectAnswer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'correctAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private Question $question;

    #[ORM\ManyToOne(targetEntity: AnswerVariant::class, inversedBy: 'correctAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private AnswerVariant $answerVariant;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getAnswerVariant(): AnswerVariant
    {
        return $this->answerVariant;
    }

    public function setAnswerVariant(AnswerVariant $answerVariant): self
    {
        $this->answerVariant = $answerVariant;
        return $this;
    }
}
