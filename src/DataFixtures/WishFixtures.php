<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WishFixtures extends Fixture implements DependentFixtureInterface
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

            $keyCategory = CategoryFixtures::$categoryKeys[
                random_int(0, count(CategoryFixtures::$categoryKeys) - 1)
            ];
            $category = $this->getReference($keyCategory, Category::class);
            $wish->setCategory($category);

            $manager->persist($wish);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
