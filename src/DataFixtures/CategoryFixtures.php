<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    static $categoryKeys = [
        'adventure',
        'sport',
        'entertainment',
        'human-relationship',
        'others'
    ];

    public function load(ObjectManager $manager): void
    {
        $adventure = new Category();
        $adventure->setName("Voyage & Aventure");
        $this->addReference(static::$categoryKeys[0], $adventure);
        $manager->persist($adventure);

        $sport = new Category();
        $sport->setName("Sport");
        $this->addReference(static::$categoryKeys[1], $sport);
        $manager->persist($sport);

        $entertainment = new Category();
        $entertainment->setName("Loisir");
        $this->addReference(static::$categoryKeys[2], $entertainment);
        $manager->persist($entertainment);

        $humanRelationship = new Category();
        $humanRelationship->setName("Relations Humaines");
        $this->addReference(static::$categoryKeys[3], $humanRelationship);
        $manager->persist($humanRelationship);

        $others = new Category();
        $others->setName("Autres");
        $this->addReference(static::$categoryKeys[4], $others);
        $manager->persist($others);

        $manager->flush();
    }
}
