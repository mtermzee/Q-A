<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/answers', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    //commentVote
    #[Route('/answers/{id}/vote', name: 'answer_vote', methods: ['POST'])]
    public function commentVote(Answer $answer, LoggerInterface $logger, Request $request, EntityManagerInterface $entityManager): Response
    {
        // todo use id to query database for comment
        $data = json_decode($request->getContent(), true);
        $direction = $data['direction'] ?? 'up';

        // use real logic here to save this to the database
        if ($direction === 'up') {
            $logger->info('Voting up!');
            $answer->setVotes($answer->getVotes() + 1);
        } else {
            $logger->info('Voting down!');
            $answer->setVotes($answer->getVotes() - 1);
        }

        //dd($answer, $request->request->all());

        $entityManager->flush();

        // return new JsonResponse($this->generateUrl('app_question_show', ['slug' => $answer->getQuestion()->getSlug()]));
        //return $this->redirectToRoute('app_question_show', ['slug' => $answer->getQuestion()->getSlug()]);
        return $this->json(['votes' => $answer->getVotes()]);
    }
}
