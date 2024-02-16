<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Search;
use DateTimeImmutable;
use Random\RandomError;
use App\DataFixtures\SearcherFixtures;
use App\Repository\SearcherRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SearchFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private SearcherRepository $searcherRepository
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $searchers = $this->searcherRepository->findAll();

        $cities = [
            'Bayonne 64100', 'Anglet 64600', 'Biarritz 64200', 'Salon de Provence 13300', 'Bordeaux 33000', 'Toulouse 31000', 'Pélissanne 13330', 'Marseille 13000', 'Lyon 69000', 'Nice 06000', 'Cannes 06400', 'Paris 75000', 'Lille 59000'
        ];


        $this->createAndPersistGroup($faker, $searchers, $cities, $manager);
        $manager->flush();

    }

    public function createAndPersistGroup(Generator $faker, array $searchers, array $cities, ObjectManager $manager)
    {
        for ($i=0; $i < 12; $i++) { 
            $cityFirst = $faker->randomElement($cities);
            if(random_int(0, 9) < 5)
            {
                $cityLast = $cityFirst;
            }
            else
            {
                $cityLast = $faker->randomElement($cities);
            }

            $search = new Search;
            $search->setSearcher($faker->randomElement($searchers))   
                    ->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setAge((string)random_int(8, 120))
                    ->setCityFirstTime($cityFirst)
                    ->setCityLastTime($cityLast)
                    ->setCreatedAt(new DateTimeImmutable())
                    ;
            // if(random_int(0, 9) < 4)
            // {
            //     $search->setMessage($faker->realTextBetween(20, 200));
            // }
            $manager->persist($search);
        }
    }

    public function getDependencies()
    {
        return [
            SearcherFixtures::class
        ];
    }
}
