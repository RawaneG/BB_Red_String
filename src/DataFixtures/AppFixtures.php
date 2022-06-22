<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->faker =  Factory::create('fr FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $mdp = $this->hasher->hashPassword($etudiant, 'passer123'); Hasher le mot de passe
        $manager->flush();
    }
}
