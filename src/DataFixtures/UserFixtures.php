<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setUsername('admin');
        $admin->setPassword('admin123'); 
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $this->addReference('user_1', $admin);

        $user1 = new User();
        $user1->setEmail('user1@example.com');
        $user1->setUsername('user1');
        $user1->setPassword('password1');
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);
        $this->addReference('user_2', $user1);

        $user2 = new User();
        $user2->setEmail('user2@example.com');
        $user2->setUsername('user2');
        $user2->setPassword('password2');
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);
        $this->addReference('user_3', $user2);

        $manager->flush();
    }
}
