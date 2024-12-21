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
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'Admin123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('user1@example.com');
        $user1->setUsername('user1');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'Password1'));
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@example.com');
        $user2->setUsername('user2');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'Password2'));
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
        $tutorial1->setContent('
        ## Introduction to Algebra
        Welcome to this tutorial on Algebra! In this guide, we will explore the fundamentals of algebra, including:
        - Understanding variables and their role.
        - Solving simple equations step by step.
        - Mastering the basic operations (addition, subtraction, multiplication, division).

        ### Why Learn Algebra?
        Algebra is a core mathematical tool that helps solve complex problems in a logical way. 
        By mastering the basics in this tutorial, you\'ll build a strong foundation for advanced math and real-world applications.

        ### Real-Life Application
        Algebra is used in many fields such as finance, engineering, and computer science to solve problems and optimize results.
        ');
        $manager->persist($tutorial1);

        $tutorial2 = new Tutorial();
        $tutorial2->setTitle('Learn Python Basics');
        $tutorial2->setDescription('A crash course in Python programming.');
        $tutorial2->setCreationDate(new \DateTime('-1 year'));
        $tutorial2->setSubject($subject2);
        $tutorial2->setContent('
        ## Learn Python Basics
        Python is a powerful and beginner-friendly programming language. In this tutorial, you will learn:
        - The fundamentals of Python syntax.
        - How to work with basic data types like integers, strings, and lists.
        - Writing and using simple functions.

        ### Why Learn Python?
        Python is versatile and widely used in industries such as web development, data analysis, artificial intelligence, and automation. It\'s beginner-friendly yet powerful enough for advanced use cases.

        ### Getting Started with Python
        Python is known for its clean and easy-to-read syntax. Here\'s how you can start:

        ````python
        def greet(name):
            return "Hello, " + name

        name = "Alice"
        print(greet(name))
        ````

        This simple function takes a name as input and returns a greeting.

        ### Data Types in Python
        Python supports various data types such as:
        - Strings: "Hello, World"
        - Integers: 42
        - Lists: [1, 2, 3, 4]

        Example of working with a list:

        ```python
        my_list = [1, 2, 3]
        my_list.append(4)
        print(my_list)
        ```

        This will output: [1, 2, 3, 4]

        ### Functions and Logic
        Functions in Python allow you to organize your code into reusable blocks. Here\'s an example:

        ```python
        def add_numbers(a, b):
            return a + b

        result = add_numbers(5, 7)
        print("The result is:", result)
        ```

        This will output: The result is: 12

        ### Real-Life Applications of Python
        Python is widely used in:
        - Automating repetitive tasks.
        - Building websites and applications.
        - Analyzing large datasets.
        - Creating machine learning models.

        By the end of this tutorial, you\'ll have the foundational knowledge to begin exploring Python programming and applying it to solve real-world problems.
        ');
        $manager->persist($tutorial2);

        $tutorial3 = new Tutorial();
        $tutorial3->setTitle("Newton's Laws of Motion");
        $tutorial3->setDescription("Understanding Newton's laws with examples.");
        $tutorial3->setCreationDate(new \DateTime('-1 year'));
        $tutorial3->setSubject($subject3);
        $tutorial3->setContent('
        ## Newton\'s Laws of Motion
        Isaac Newton\'s three laws of motion form the foundation of classical mechanics. Let\'s explore them:

        ### First Law: The Law of Inertia
        An object will remain at rest or in uniform motion unless acted upon by an external force.

        ### Second Law: F = ma
        Force equals mass times acceleration. This means that the force applied to an object is directly proportional to its mass and acceleration.

        ### Third Law: Action and Reaction
        For every action, there is an equal and opposite reaction.

        ### Real-Life Application
        Newton\'s laws are fundamental in designing vehicles, understanding sports physics, and even planning space missions.
        ');
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
