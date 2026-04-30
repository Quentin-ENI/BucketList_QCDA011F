<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($index = 0; $index < 100; $index++) {
            $wish = new Wish();
            $wish->setTitle($faker->sentence($nbWords = 4, $variableNbWords = true));
            $wish->setDescription($faker->paragraph($nbSentences = 2, $variableNbSentences = true));
            $wish->setAuthor($faker->name());
            $wish->setIsPublished($faker->boolean());
            $wish->setDateCreated($faker->dateTime());
            $wish->setDateUpdated(null);

            $manager->persist($wish);
        }

        $manager->flush();
    }
}
