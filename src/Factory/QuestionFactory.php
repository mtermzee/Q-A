<?php

namespace App\Factory;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Question>
 *
 * @method static Question|Proxy createOne(array $attributes = [])
 * @method static Question[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Question|Proxy find(object|array|mixed $criteria)
 * @method static Question|Proxy findOrCreate(array $attributes)
 * @method static Question|Proxy first(string $sortedField = 'id')
 * @method static Question|Proxy last(string $sortedField = 'id')
 * @method static Question|Proxy random(array $attributes = [])
 * @method static Question|Proxy randomOrCreate(array $attributes = [])
 * @method static Question[]|Proxy[] all()
 * @method static Question[]|Proxy[] findBy(array $attributes)
 * @method static Question[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Question[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static QuestionRepository|RepositoryProxy repository()
 * @method Question|Proxy create(array|callable $attributes = [])
 */
final class QuestionFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    public function unpublished(): self
    {
        return $this->addState(['askedAt' => null]);
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            /*'name' => self::faker()->text(),
            'slug' => self::faker()->text(),
            'question' => self::faker()->text(),
            'votes' => self::faker()->randomNumber(),

            <<<EOF
                This is a question about something. 
            
                I want to know more about something. Can you tell me more about something?
            EOF
            */

            // faker for really good fake data
            'name' => self::faker()->realText(40),
            //'slug' => self::faker()->slug(),
            'question' => self::faker()->paragraphs(
                self::faker()->numberBetween(1, 4),
                true
            ),
            //'askedAt' => rand(1, 10) > 2 ? new \DateTime(sprintf('-%d days', rand(1, 100))) : null,
            //'askedAt' => self::faker()->boolean(70) ? self::faker()->dateTimeBetween('-100 days', '-1 minute') : null,
            'askedAt' =>  self::faker()->dateTimeBetween('-100 days', '-1 minute'),
            'votes' => rand(-20, 50)
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            //->afterInstantiate(function (Question $question): void { )}
            /*->afterInstantiate(function (Question $question): void {
                if (!$question->getSlug()) {
                    $slugger = new AsciiSlugger();
                    $question->setSlug($slugger->slug($question->getName()));
                }
            });*/;
    }

    protected static function getClass(): string
    {
        return Question::class;
    }
}
