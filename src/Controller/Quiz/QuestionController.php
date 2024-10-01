<?php

declare(strict_types=1);

namespace App\Controller\Quiz;

use App\Model\Quiz\Entity\Question;
use App\Model\Quiz\Service\QuestionManager;
use App\Model\Quiz\UseCase\Start;
use App\Model\Quiz\UseCase\SaveAnswer;
use App\Repository\Quiz\QuestionRepository;
use App\Repository\Quiz\UserResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question', name: 'question.')]
class QuestionController extends AbstractController
{
    #[Route('/start', name: 'start')]
    public function start(
        Start\Handler $handler,
        QuestionRepository $questionRepository,
        UserResultRepository $userResultRepository,
    ): Response
    {

        $user = $this->getUser();
        $command = new Start\Command();
        $command->id = $user->getId();
        $handler->handle($command);

        $userResult = $userResultRepository->getLatestByUser($user);
        $question = $questionRepository->findRandomUnansweredQuestion($userResult);
        return $this->redirectToRoute('question.index', ['id' => $question->getId()]);
    }

    #[Route('/{id}/show', name: 'index')]
    public function question(
        Question $question,
        Request $request,
        SaveAnswer\Handler $handler,
        UserResultRepository $userResultRepository,
        QuestionRepository $questionRepository
    ): Response
    {
        $user = $this->getUser();
        $userResult = $userResultRepository->getLatestByUser($user);

        $command = new SaveAnswer\Command(
            $userResult->getId()->toString(),
            $question->getId()->toString()
        );

        $form = $this->createForm(SaveAnswer\Form::class, $command, [
            'question' => $question,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $question = $questionRepository->findRandomUnansweredQuestion($userResult);
                $this->addFlash('success', 'Ваш ответ сохранен');

                if ($userResult->getStatus()->isFinish()) {
                    return $this->redirectToRoute('question.result');
                }

                return $this->redirectToRoute('question.index', ['id' => $question->getId()]);
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('question/index.html.twig', [
            'questionForm' => $form->createView(),
            'question' => $question,
        ]);
    }

    #[Route('/result', name: 'result')]
    public function results(
        UserResultRepository $userResultRepository,
        QuestionManager $questionManager
    ): Response
    {
        $user = $this->getUser();
        $userResult = $userResultRepository->getLatestByUser($user);

        if ($userResult->getStatus()->isProcess()) {
            return $this->redirectToRoute('question.start');
        }

        $questionsData = $questionManager->prepareQuestionsData($userResult->getUserAnswers());

        return $this->render('question/result.html.twig', [
            'username' => $user->getUsername(),
            'testTakenAt' => $userResult->getTestTakenAt(),
            'questionsData' => $questionsData,
        ]);
    }
}
