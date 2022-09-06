<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    #[Route('/question/{slug}', name: 'app_question_show')]
    public function show($slug, MarkdownParserInterface $parser): Response
    {
        $answers = [
            'This is my `first` answer',
            'This is my second answer',
            'This is my third answer',
        ];
        $questionText = 'Why does the sun go on shining?';
        $parsedQuestionText = $parser->transformMarkdown($questionText);

        // debuging
        dump($slug, $this);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $parsedQuestionText,
            'answers' => $answers,
        ]);
    }
}
