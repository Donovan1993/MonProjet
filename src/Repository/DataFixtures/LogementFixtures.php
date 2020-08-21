<?php

namespace App\DataFixtures;

use App\Entity\Logement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LogementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $logement = new Logement();
            $logement
                ->setTitle($faker->words(3, true))
                ->setPrice($faker->numberBetween(1100, 3350))
                ->setPostalCode($faker->postcode)
                ->setRooms($faker->numberBetween(2, 12))
                ->setSurface($faker->numberBetween(20, 350))
                ->setBedrooms($faker->numberBetween(2, 7))
                ->setHeat($faker->numberBetween(0, count(Logement::HEAT) - 1))
                ->setDescription($faker->sentences(4, true))
                ->setCity($faker->city)
                ->setName($faker->words(2, true))
                ->setFloor($faker->numberBetween(2, 7))
                ->setAddress($faker->address);

            $manager->persist($logement);
        }
        // $product = new Product();


        $manager->flush();
    }
}
