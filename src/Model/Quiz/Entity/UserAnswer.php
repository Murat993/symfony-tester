<?php

declare(strict_types=1);

namespace App\Model\Quiz\Entity;

use App\Repository\Quiz\UserAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserAnswerRepository::class)]
#[ORM\Table(name: 'user_answers')]
class UserAnswer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: UserResult::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'user_result_id', referencedColumnName: 'id', nullable: false)]
    private UserResult $userResult;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: false)]
    private Question $question;

    #[ORM\ManyToOne(targetEntity: AnswerVariant::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'answer_variant_id', referencedColumnName: 'id', nullable: true)]
    private ?AnswerVariant $answerVariant = null;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUserResult(): UserResult
    {
        return $this->userResult;
    }

    public function setUserResult(UserResult $userResult): self
    {
        $this->userResult = $userResult;
        return $this;
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

    public function getAnswerVariant(): ?AnswerVariant
    {
        return $this->answerVariant;
    }

    public function setAnswerVariant(?AnswerVariant $answerVariant): self
    {
        $this->answerVariant = $answerVariant;
        return $this;
    }
}
