Ganze Sachen unter diesem Link:
https://symfonycasts.com/tracks/symfony5

https://symfonycasts.com/screencast/symfony3-forms/save-redirect-set-flash
https://symfony.com/doc/current/frontend/ux.html

----------------------------make prject---------------------------------
// Erase the whole cache
php symfony cache:clear
./bin/console cache:clear

composer create-project symfony/skeleton "name"
cd PATH
composer require webapp
composer require symfony/webapp-pack
Run "composer recipes" at any time to see the status of your Symfony recipes.

run server:
symfony server:start -d
symfony server:stop 

infos:
symfony console
symfony -v
php bin/console

update:
https://symfony.com/doc/current/setup/unstable_versions.html
composer update

- Annotation benutzen
composer require annotations
- nun zeit to Erstellen des Controllers
symfony console make:controller "QuestionController"
- Security Checker
composer require sec-checker
- show all routes inside the projekt (url)
symfony console debug:router
- add twig (Tamplates folder)
composer require twig
https://twig.symfony.com/
- add dubging
composer require debug
-add asset
composer require symfony/asset

-JSON API Endpoint
symfony console make:controller "CommentController"

-Service Objects:
Php bin/console debug:autowiring --all  -> this show all Services
Twig
Logger
Cache
Connection database
HttpClient
Router


**********Symfony 5 Fundamentals: Services, Config & Environments*************** 
Services
Autowiring
Configurations 

-KnpMarkdownBundle & Service : for html tags by Render
https://github.com/KnpLabs/KnpMarkdownBundle
composer require knplabs/knp-markdown-bundle
MarkdownParserInterface 

-Cache Service: 
Php bin/console debug:autowiring cache   -> to see which services are on in our app
CacheInterface 

-Configuring Bundles: to control the services
https://symfonycasts.com/screencast/symfony5-fundamentals/bundle-config
-The Service Container & Autowiring
https://symfonycasts.com/screencast/symfony5-fundamentals/debug-container

-Configuring the Cache Service:
https://symfonycasts.com/screencast/symfony5-fundamentals/cache-config

-Environments:
https://symfonycasts.com/screencast/symfony5-fundamentals/environments

-Controlling the prod Environment:
https://symfonycasts.com/screencast/symfony5-fundamentals/prod-environment


-Creating a Service: own service class just for organize the code (z.b. Firebase service)
Create a folder in src and put class.php inside it and create ur own services as funktions
Php bin/console debug:autowiring `Markdown` --all 

-Autowiring Dependencies into a Service
https://symfonycasts.com/screencast/symfony5-fundamentals/dependency-injection

-Parameters

-Service Config & Non-Autowireable Arguments

-All about services.yaml

-Binding Global Arguments

-Named Autowiring

-Fetching Non-Autowireable Services

-Controllers: Boring, Beautiful Services

-Environment Variables
https://docs.sentry.io/platforms/php/guides/symfony/
For sending logger and Caching there and watch them inside this plugin

-The Secrets Vault
Inside the .env we can make database connection and Api keys

-Using & Overriding Secrets

**Custom Console Command**
-MakerBundle & Autoconfigure: it gives a huge console commands
Composer require maker --dev
./bin/console make:			-> show all commands
`now we can add this make to our symphony commands just follow`
./bin/console make:command
 -> app:random-spell. 
 -> for testing: ./bin/console app:random-spell

-Playing with a Custom Console Command


-Making a Twig Extension (Filter)
./bin/console make:twig-extension
./bin/console debug:twig
**************************************************************


***************Doctrine, Symfony & the Database***************
Database

-setup a database with doctrine
symfony console list doctrin
composer require symfony/ore-pack
composer require --dev symfony/maker-bundle

-inside .env
DATABASE_URL="mysql://root:admin@127.0.0.1:3306/movies?serverVersion=5.7&charset=utf8mb4"
symfony console doctrine:database:create
symfony console doctrine:database:drop

-or user docker
./bin/console make:docker:database
 Next:
  A) Run docker-compose up -d database to start your database container
     or docker-compose up -d to start all of them.
	 docker-compose down  drop and destroy container 
	
 
  B) If you are using the Symfony Binary, it will detect the new service automatically.
     Run symfony var:export --multiline to see the environment variables the binary is exposing.
     These will override any values you have in your .env files.
 
  C) Run docker-compose stop will stop all the containers in docker-compose.yaml.
     docker-compose down will stop and destroy the containers.

-docker-compose & Exposed Ports
Docker-compose
Docker-compose ps         :     show all containers cuz the ports change every time
Docker-compose exec database mysql -u root -password:password        : install mysql inside container
Mysql -u root --password:password --host=127.0.0.1 --port=50769	  : connect to database
 -> SHOW DATABASES;
 -> CREATE DATABASE docker_coolness;

-docker-compose Env Vars & Symfony
Symfony serve -d
Symfony var:export --multiline        : show all infos about database


-doctrine:database:create & server_version
https://hub.docker.com/_/mysql
symfony console doctrine:database:create
symfony console doctrine:database:drop

-Entity Class: corresponding php class
-create an entity
-annotations: https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/reference/annotations-reference.html
symfony console make:entity
-add fild to entity
symfony console make:entity "name"
-migration based on database
symfony console make:migration
-create the table in datebase from migration
symfony console doctrine:migrations:migrate
symfony console doctrine:migrations:list


-Persisting to the Database
EntityManagerInterface
     $em->persist($question);
     $em->flush();
Symfony console doctrine:query:sql 'SELECT * FROM question'

-Fetching Data & The Repository
$repository = $em->getRepository(Question::class);
$question = $repository->findOneBy(['slug' => $slug]);

-Entity objects in Twig

-"5 Minutes Ago" Strings		: |ago
Composer require knplabs/knp-time-bundle

-Custom Repository Class
$questions = $repository->findBy([], ['askedAt' => 'DESC']);
Inside the repo order u can write ur own queris
findAllAskedOrderedByNewest()

-DQL & The Query Builder
https://symfonycasts.com/screencast/doctrine-queries

-Reusing Query Logic & Param Converters
Inside the repo order:	2 private functions

-Automatic Controller Queries: Param Converter
Not using the $repo instate of that we use the Entity 

-Smarter Entity Methods
symfony console make:entity Question
Votes

-Request Object & POST Data
As controller arguments(variables)
 - name as $slug
 - service as LoggerInterface
 - Entity as Question for Query
 - Request 

-Update Query & Rich vs Anemic Models
Vote in database updaten and redirect the page

-dummy data through Data Fixtures
composer require --dev doctrine/doctrine-fixtures-bundle
-load data fixtures to database
symfony console doctrine:fixtures:load
-Foundry: Fixture Model Factories 		: using factory  Fake data
https://github.com/zenstruck/foundry
https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html
composer require zenstruck/foundry --dev
Symfony console make:factory
symfony console doctrine:fixtures:load

-Foundry Tricks  : sehr gut für real fake data
https://symfonycasts.com/screencast/symfony5-doctrine/foundry-tricks

-Sluggable: Doctrine Extensions	: 	its about slug(unique url)
https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html
composer require stof/doctrine-extensions-bundle

-Timestampable & Failed Migrations	:	created-at , updated-at
https://github.com/doctrine-extensions/DoctrineExtensions
Drop database:	symfony console doctrine:database:drop --force
Create database: symfony console doctrine:database:create
Symfony console doctrine:query:sql 'SELECT * FROM question'
Symfony console make:migration		:	to make them required 
**************************************************************


*****************Mastering Doctrine Relations*****************

-The Answer Entity
symfony console make:entity
Symfony console make:migration
symfony console doctrine:migrations:migrate

-The ManyToOne Relation
Each answer has one question and each question has many answers -> Answer field has question_id in database
symfony console make:entity Answer
	-question
	-relation
	-Question
	-ManyToOne
	-no
	-yes
	-answers
	-no

 ------------ ---------------------------------------------------------------------- 
  Type         Description                                                           
 ------------ ---------------------------------------------------------------------- 
  ManyToOne    Each Answer relates to (has) one Question.                            
               Each Question can relate to (can have) many Answer objects            
                                                                                     
  OneToMany    Each Answer can relate to (can have) many Question objects.           
               Each Question relates to (has) one Answer                             
                                                                                     
  ManyToMany   Each Answer can relate to (can have) many Question objects.           
               Each Question can also relate to (can also have) many Answer objects  
                                                                                     
  OneToOne     Each Answer relates to (has) exactly one Question.                    
               Each Question also relates to (has) exactly one Answer.               
 ------------ ---------------------------------------------------------------------- 

-Saving Relations
 $answer->setQuestion($question);

-Relations in Foundry	:	create answers to random questions in database
Symfony console make:factory

-Foundry: Always Pass a Factory Instance to a Relation
Symfony console doctrine:query:sql 'SELECT DISTINCT(question_id) FROM answer'
Using unpublished method in appfixtuers und in answerfaktory

-Fetching Relations
Just in Controller

-Rendering Answer Data & Saving Votes
In controller and twig
Here we can render the answers for the question in the twig by calling question.answers

-Owning Vs Inverse Sides of a Relation

-Relation OrderBy & fetch=EXTRA_LAZY
In eintity

-Filtering to Return only Approved Answers
https://symfonycasts.com/screencast/doctrine-relations/answer-status
Watch it again for answer-status


-Collection Criteria for Custom Relation Queries
About performance to render the answers 

-How to Configure a Redirect without a custom Controller
https://symfony.com/doc/4.1/routing/redirect_in_config.html

-Most Popular Answers Page

-The |u Filter & String Component
In the Entity Answer add methods
https://symfony.com/doc/current/components/string.html#usage


-Joining Across a Relationship & The N + 1 Problem
https://stackoverflow.com/questions/97197/what-is-the-n1-selects-problem-in-orm-object-relational-mapping
https://medium.com/doctolib/understanding-and-fixing-n-1-query-30623109fe89
For more query performence	-> makes the getmostpopluar in one Query so goooood.

-Search, the Request Object & OR Query Logic
Really nice one in most popular make search for answers and questions
elasticsearch for smarter search

-The 4 (2?) Possible Relation Types
ManyToOne, OneToMany, OneToOne -> are really the same realstionship
ManyToMany -> its deferent lest make one here. By doing Tags
OneToOne -> USER, Profile: in one class to reduce the complexity
		-> wait until you have real performance problems and then debug it.
symfony console make:entity
	- Tag
	- name
	- string
	- 255
	- no
Symfony console make:migration
symfony console doctrine:migrations:migrate

-ManyToMany Relation
Each Tag has many questions and each Question has many Tags.  No deferents where:
symfony console make:entity
	-taggedAt
	-dateTime-im
	-no
	-Question
	-tags
	-relation
	-Tag
	-ManyToMany
	-yes
	-questions

-Saving Items in a ManyToMany Relation
In Appfixtuers

-Handling ManyToMany in Foundry
Symfony console make:factory
	-Tag

-Joining Across a ManyToMany : fixing N + 1 Problem
To get les querys and more performance HOW:
Like how we did to answers in AnswerRepo by joining across the question relationship and then selecting the question data.


-ManyToMany... with Extra Fields on the Join Table?	
As soon we need one extra column on this manytomany, we need to stop using a ManytoMany relationship instead we need to create an Entity for the join table and manually relate the entity to question and tag. So the entity QuestionTag
But I will not use it so I will use the manytomany
-When a Migration Falls Apart
-QuestionTag Fixtures & DateTimeImmutable with Faker
Here I do not use QuestionTag I use the old manytomany Tag
-Doing Crazy things with Foundry & Fixtures
-JOINing Across Multiple Relationships

-Pagination with Pagerfanta
To make see more questions -> doctrine features -> KnpPagiator, Pagerfanta
When we use it so we do not need to query the data directly instead, our job to create a querybuilder and pass that to the pagerinator-> which will then figure out which page we are on, set up the limit and offset parts of the query and then execute it.
https://github.com/BabDev/PagerfantaBundle
composer require babdev/pagerfanta-bundle
composer require pagerfanta/doctrine-orm-adapter

-Themed Pagination Links
composer require pagerfanta/twig
Configurations for the view:
./bin/console cache:clear

**************************************************************

-How to Compile Assets in Symfony for frontend frameworks:
composer require symfony/asset
composer require encore
composer require symfony/webpack-encore-bundle
npm install
npm run watch

-Install tailwind in symfony
npm install -D tailwindcss postcss-loader purgecss-webpack-plugin glob-all path
npx tailwindcss init -p
-after config:
npx tailwindcss -i ./assets/styles/app.css -o ./public/build/app.css --watch
**************************************************************

-How to use images in symfony:

**************************************************************

-CRUD:
-For Form we use Symfony-form:
composer require symfony/form
-Then make Form:
symfony console make:form MovieFormType "which entity"
composer require symfony/mime
**************************************************************

Validation Constraints Reference:
https://symfony.com/doc/current/reference/constraints.html
**************************************************************

-Symfony Authentication:
composer require symfony/security-bundle
authentication - login, log out
authorization - user CRUD

symfony console make:user User
symfony console make:registration-form

symfony console make:auth
-	1
-	LoginFormAuthenticator
-	
-	yes


