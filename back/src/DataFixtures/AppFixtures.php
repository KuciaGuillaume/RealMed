<?php

namespace App\DataFixtures;

use App\Entity\Medicine;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('User');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);
        $user1 = new User();
        $user1->setUsername('Admin');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword($this->passwordHasher->hashPassword($user, 'password123'));

        $manager->persist($user1);

        $medecine = new Medicine();

        $medecine1 = new Medicine();
        $medecine2 = new Medicine();
        $manager->flush();
    }
}
