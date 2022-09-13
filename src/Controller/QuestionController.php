<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

class QuestionController extends AbstractController
{
    #[Route('/questions/{page<\d+>}', name: 'app_homepage')]
    public function index(QuestionRepository $qr, Request $request, int $page = 1): Response
    {
        //$repository = $em->getRepository(Question::class);
        // $questions = $repository->findAll();        
        // $questions = $repository->findBy([], ['askedAt' => 'DESC']);        //findAllAskedOrderedByNewest()
        //$questions = $qr->findAllAskedOrderedByNewest();
        $queryBuilder = $qr->createAskedOrderByNewestQueryBuilder();

        $pagerfanta = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($page);
        //$pagerfanta->setCurrentPage($request->query->getInt('page', 1));
        //dd($questions);

        return $this->render('question/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/questions/new')]
    public function new(EntityManagerInterface $em): Response
    {
        return new Response("This is the new question page");
    }

    //Automatic Controller Queries: Param Converter
    #[Route('/questions/{slug}', name: 'app_question_show')]
    public function show(Question $question, AnswerRepository $answerRepository): Response
    {
        //$slug, EntityManagerInterface $em, MarkdownParserInterface $parser, CacheInterface $cache,
        // get Data from database
        //$repository = $em->getRepository(Question::class);
        /**  @var Qeustion|null $question */
        //$question = $repository->findOneBy(['slug' => $slug]);
        /* if (!$question) {
            throw $this->createNotFoundException(sprintf('No question found for slug "%s"', $slug));
        }*/


        // get answers
        //$answers = $answerRepository->findBy(['question' => $question]);
        // dd($answers);
        //or 
        //$answers = $question->getAnswers();
        /* foreach ($answers as $answer) {
            dump($answer);
            //$answer->getAnswer();
        }*/

        /* $answers = [
            'This is my `first` answer',
            'This is my second answer',
            'This is my third answer',
        ];*/

        //KnpMarkdownBundle
        //$parsedQuestionText = $parser->transformMarkdown($questionText);
        // cache
        /*$parsedQuestionText = $cache->get('markdown_' . md5($questionText), function () use ($questionText, $parser) {
            return $parser->transformMarkdown($questionText);
        }); now with the new own Serivce */
        /*$questionText = 'Why does the *sun* go on shining?';
        $parsedQuestionText = $markdownHelper->parse($questionText, $parser, $cache);*/

        // debuging
        //dump($slug, $this);

        //$answers = $question->getAnswers();

        return $this->render('question/show.html.twig', [
            /*'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $parsedQuestionText,*/
            'question' => $question,
            //'answers' => $answers,
        ]);
    }

    #[Route('/questions/{slug}/vote', name: 'app_question_vote', methods: ['POST'])]
    public function questionVoteCount(Question $question, Request $request, EntityManagerInterface $em)
    {

        $direction = $request->request->get('direction');

        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }

        //dd($question, $request->request->all());

        $em->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug(),
        ]);
    }
}
