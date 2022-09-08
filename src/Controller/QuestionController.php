<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/questions', name: 'app_homepage')]
    public function index(QuestionRepository $qr): Response
    {
        //$repository = $em->getRepository(Question::class);
        // $questions = $repository->findAll();        
        // $questions = $repository->findBy([], ['askedAt' => 'DESC']);        //findAllAskedOrderedByNewest()
        $questions = $qr->findAllAskedOrderedByNewest();

        //dd($questions);

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/questions/new')]
    public function new(EntityManagerInterface $em): Response
    {
        $question = new Question();
        $question->setName('Some question')
            ->setSlug('some-question-' . rand(0, 1000))
            ->setQuestion(<<<EOF
                This is a question to test how it works.
              EOF);
        if (rand(1, 10) > 2) {
            $question->setAskedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }
        $question->setVotes(rand(-20, 50));

        //dd($question);
        // add to database
        $em->persist($question);
        $em->flush();

        return new Response(sprintf(
            'Hiya! We just created a new question with the id: %s',
            $question->getId(),
            $question->getSlug()
        ));
    }

    //Automatic Controller Queries: Param Converter
    #[Route('/questions/{slug}', name: 'app_question_show')]
    public function show(Question $question, MarkdownHelper $markdownHelper): Response
    {
        //$slug, EntityManagerInterface $em, MarkdownParserInterface $parser, CacheInterface $cache,
        // get Data from database
        //$repository = $em->getRepository(Question::class);
        /**  @var Qeustion|null $question */
        //$question = $repository->findOneBy(['slug' => $slug]);
        /* if (!$question) {
            throw $this->createNotFoundException(sprintf('No question found for slug "%s"', $slug));
        }*/

        $answers = [
            'This is my `first` answer',
            'This is my second answer',
            'This is my third answer',
        ];

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

        return $this->render('question/show.html.twig', [
            /*'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $parsedQuestionText,*/
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    #[Route('/questions/{slug}/vote', name: 'app_question_vote', methods: ['POST'])]
    public function questionVoteCount(Question $question, Request $request)
    {
        //dd($question->getVotes(), $request->request->all());

        $direction = $request->request->get('direction');

        if ($direction === 'up') {
            $question->setVotes($question->getVotes() + 1);
        } elseif ($direction === 'down') {
            $question->setVotes($question->getVotes() - 1);
        }

        dd($question, $request->request->all());
    }
}
