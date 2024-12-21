<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Chapter;
use App\Entity\Comment;
use App\Entity\Subject;
use App\Entity\Tutorial;
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
        // Users
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('user1@example.com');
        $user1->setUsername('user1');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password1'));
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@example.com');
        $user2->setUsername('user2');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'password2'));
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        // Subjects
        $subject1 = new Subject();
        $subject1->setName('Mathematics');
        $subject1->setDescription('All about numbers and calculations.');
        $manager->persist($subject1);

        $subject2 = new Subject();
        $subject2->setName('Programming');
        $subject2->setDescription('Learn programming languages and techniques.');
        $manager->persist($subject2);

        $subject3 = new Subject();
        $subject3->setName('Physics');
        $subject3->setDescription('Explore the laws of the universe.');
        $manager->persist($subject3);

        // Tutorials
        $tutorial1 = new Tutorial();
        $tutorial1->setTitle('Introduction to Algebra');
        $tutorial1->setDescription("A beginner's guide to algebra.");
        $tutorial1->setCreationDate(new \DateTime('-1 year'));
        $tutorial1->setSubject($subject1);
        $manager->persist($tutorial1);

        $tutorial2 = new Tutorial();
        $tutorial2->setTitle('Learn Python Basics');
        $tutorial2->setDescription('A crash course in Python programming.');
        $tutorial2->setCreationDate(new \DateTime('-1 year'));
        $tutorial2->setSubject($subject2);
        $manager->persist($tutorial2);

        $tutorial3 = new Tutorial();
        $tutorial3->setTitle("Newton's Laws of Motion");
        $tutorial3->setDescription("Understanding Newton's laws with examples.");
        $tutorial3->setCreationDate(new \DateTime('-1 year'));
        $tutorial3->setSubject($subject3);
        $manager->persist($tutorial3);

        // Chapters
        $chapter1 = new Chapter();
        $chapter1->setTitle('What is Algebra?');
        $chapter1->setContent('An introduction to algebra, its uses, and its history.');
        $chapter1->setPosition(1);
        $chapter1->setTutorial($tutorial1);
        $manager->persist($chapter1);

        $chapter2 = new Chapter();
        $chapter2->setTitle('Basic Algebraic Operations');
        $chapter2->setContent('Learn the fundamental operations in algebra.');
        $chapter2->setPosition(2);
        $chapter2->setTutorial($tutorial1);
        $manager->persist($chapter2);

        $chapter3 = new Chapter();
        $chapter3->setTitle('Setting Up Python');
        $chapter3->setContent('How to install and configure Python on your system.');
        $chapter3->setPosition(1);
        $chapter3->setTutorial($tutorial2);
        $manager->persist($chapter3);

        // Comments
        $comment1 = new Comment();
        $comment1->setContent('This tutorial is very helpful!');
        $comment1->setCreationDate(new \DateTime('-1 year'));
        $comment1->setTutorial($tutorial1);
        $comment1->setUser($user1);
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setContent('I struggled with algebra, but this made it easy.');
        $comment2->setCreationDate(new \DateTime('-1 year'));
        $comment2->setTutorial($tutorial2);
        $comment2->setUser($user2);
        $manager->persist($comment2);

        $manager->flush();
    }
}
