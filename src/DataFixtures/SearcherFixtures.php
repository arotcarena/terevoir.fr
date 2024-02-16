<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Searcher;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SearcherFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        for ($i=0; $i < 10; $i++) { 
            $searcher = new Searcher;
            $searcher->setFirstName($faker->firstName())
                        ->setLastName($faker->lastName())
                        ->setBirthYear((string)random_int(1900, 2015))
                        ->setEmail($faker->email())
                        ->setPhone($faker->phoneNumber())
                        ->setCreatedAt(new DateTimeImmutable())
                        ->setConsent(true)
                        ;
            $manager->persist($searcher);
        }
        $manager->flush();
    }
}


