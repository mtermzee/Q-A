<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

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
    public function show($slug, MarkdownParserInterface $parser, CacheInterface $cache, MarkdownHelper $markdownHelper): Response
    {
        $answers = [
            'This is my `first` answer',
            'This is my second answer',
            'This is my third answer',
        ];
        $questionText = 'Why does the *sun* go on shining?';
        //KnpMarkdownBundle
        //$parsedQuestionText = $parser->transformMarkdown($questionText);
        // cache
        /*$parsedQuestionText = $cache->get('markdown_' . md5($questionText), function () use ($questionText, $parser) {
            return $parser->transformMarkdown($questionText);
        }); now with the new own Serivce */
        $parsedQuestionText = $markdownHelper->parse($questionText, $parser, $cache);

        // debuging
        dump($slug, $this);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $parsedQuestionText,
            'answers' => $answers,
        ]);
    }
}
