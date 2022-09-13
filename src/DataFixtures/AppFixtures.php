<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Tag;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /* $question = new Question();
        $question->setName('Some question')
            ->setSlug('some-question-' . rand(0, 1000))
            ->setQuestion(<<<EOF
                This is a question about something. 
                
                I want to know more about something. Can you tell me more about something?
              EOF);
        if (rand(1, 10) > 2) {
            $question->setAskedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }
        $question->setVotes(rand(-20, 50));

        //dd($question);
        // add to database
        $manager->persist($question);
        $manager->flush();*/

        // use Factory instate of Fixtures
        // QuestionFactory::new()->create();
        TagFactory::new()->createMany(100);

        // create 20 questions
        $questions = QuestionFactory::new()->createMany(20, function () {
            // we user return to rlate defrrent id-tags to defrrent questions
            return [
                // realte tags to questions randomly
                'tags' => TagFactory::randomRange(0, 5)
            ];
        });

        QuestionFactory::new()
            ->unpublished()
            ->createMany(5);

        /*$answer = new Answer();
        $answer->setContent('This is a test answer')
            ->setUsername('John Doe');

        $question = new Question();
        $question->setName('Some question')
            ->setQuestion('.... I want to know more about something. Can you tell me more about something?');

        $answer->setQuestion($question);

        $manager->persist($answer);
        $manager->persist($question);*/
        AnswerFactory::new(function () use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]
            ];
        })->needsApproval()->many(20)->create();

        AnswerFactory::createMany(100, function () use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]
            ];
        });

        /*$question = QuestionFactory::createOne()->object();
        $tag1 = new Tag();
        $tag1->setName('diosaurs');
        // realte tgas to questions
        $question->addTag($tag1);
        $manager->persist($tag1);*/

        $manager->flush();
    }
}
