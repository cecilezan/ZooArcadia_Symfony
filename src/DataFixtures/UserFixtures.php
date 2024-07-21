<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Exception;
use Faker;

 /** @throws Exception */
class UserFixtures extends Fixture
{
    public const USER_NB_TUPLES = 10;
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= self::USER_NB_TUPLES; $i++) {
            $user = (new User())
                ->setPrenom($faker->firstName())
                ->setName($faker->lastName())
                ->setEmail("email$i@mail.com")
                ->setCreatedAt(new DateTimeImmutable());

            $user->setPassword($this->passwordHasher->hashPassword($user, "Azerty@123"));

            $manager->persist($user);

        }

        $manager->flush();
    }
}
