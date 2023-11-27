<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{


    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordEncoder = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
         $user1 = new User();
         $user1->setEmail('hello@asortf.org');
         $user1->setFirstname('Romain');
         $user1->setLastname('Genin');
         $user1->setBirthday(new \DateTime());
         $user1->setPhone('0680549606');
         $user1->setLicenceId('A-1234-1234');
         $user1->setRoles(['ROLE_EDIT', 'ROLE_LICENCEE']);

        $password = $this->passwordEncoder->hashPassword($user1, 'admin');

        $user1->setPassword($password);

        $user2 = new User();
        $user2->setEmail('licencee@asortf.org');
        $user2->setFirstname('Paul');
        $user2->setLastname('Dupond');
        $user2->setBirthday(new \DateTime('1978-12-10'));
        $user2->setPhone('0987654321');
        $user2->setLicenceId('B-5678-9012');
        $user2->setRoles(['ROLE_LICENCEE']);

        $password = $this->passwordEncoder->hashPassword($user2, 'admin');

        $user2->setPassword($password);
         $manager->persist($user2);
         $manager->persist($user1);

        $manager->flush();
    }
}
