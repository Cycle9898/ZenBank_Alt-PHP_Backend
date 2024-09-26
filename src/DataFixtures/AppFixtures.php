<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName("Test");
        $user->setLastName("User");
        $user->setAddress1("13, Rue des tests");
        $user->setBirthDate("01/01/2001");
        $user->setDwollaCustomerId("9da3aa7c-2524-430b-a751-6dc722735fce");
        $user->setDwollaCustomerUrl("https://api-sandbox.dwolla.com/customers/9da3aa7c-2524-430b-a751-6dc722735fce");
        $user->setEmail("test.user@fake.com");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password123"));
        $user->setLocality("Paris");
        $user->setPostalCode("75000");
        $user->setRoles(["ROLE_USER"]);

        $manager->persist($user);
        $manager->flush();
    }
}
