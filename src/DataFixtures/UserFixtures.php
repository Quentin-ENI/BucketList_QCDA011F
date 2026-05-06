<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $harry = new User();
        $harry->setEmail("harry.potter@mail.com");
        $harry->setUsername("harry");
        $harry->setPassword(
            $this->userPasswordHasher->hashPassword($harry, "nimbus2000")
        );
        $this->addReference("harry", $harry);
        $manager->persist($harry);

        $hermione = new User();
        $hermione->setEmail("hermione.granger@mail.com");
        $hermione->setUsername("hermione");
        $hermione->setPassword(
            $this->userPasswordHasher->hashPassword($hermione, "granger")
        );
        $hermione->setRoles(["ROLE_ADMIN"]);
        $this->addReference("hermione", $hermione);
        $manager->persist($hermione);

        $manager->flush();
    }
}
