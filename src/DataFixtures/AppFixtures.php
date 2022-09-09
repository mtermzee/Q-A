<?php

namespace App\DataFixtures;

use App\Factory\QuestionFactory;
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
        QuestionFactory::new()->createMany(20);

        QuestionFactory::new()
            ->unpublished()
            ->createMany(5);
    }
}
