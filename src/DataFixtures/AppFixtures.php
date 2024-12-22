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
        $admin->setEmail('aminairi@example.com');
        $admin->setUsername('vive_esgi');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'ViveJWT123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setName('Nairi');
        $admin->setFirstName('Amin');
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('amontoya@example.com');
        $user1->setUsername('amontoya');
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'GemLeDinosaure98'));
        $user1->setRoles(['ROLE_USER']);
        $user1->setName('Goat');
        $user1->setFirstName('Alexis');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('vasseurbaptiste@example.com');
        $user2->setUsername('symfony_goat');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'FuckLaravel666'));
        $user2->setRoles(['ROLE_BANNED']);
        $user2->setName('Vasseur');
        $user2->setFirstName('Baptiste');
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
        $tutorial1->setTitle('Introduction à l\'algèbre');
        $tutorial1->setDescription("Un guide pour débuter en algèbre.");
        $tutorial1->setCreationDate(new \DateTime('-1 year'));
        $tutorial1->setSubject($subject1);
        $tutorial1->setContent('
        ## Introduction à l\'algèbre
        Bienvenue dans ce tutoriel sur l\'algèbre ! Dans ce guide, nous allons explorer les bases de l\'algèbre, notamment :
        - Comprendre les variables et leur rôle.
        - Résoudre des équations simples étape par étape.
        - Maîtriser les opérations de base (addition, soustraction, multiplication, division).

        ### Pourquoi apprendre l\'algèbre ?
        L\'algèbre est un outil mathématique fondamental qui permet de résoudre des problèmes complexes de manière logique.
        En maîtrisant les bases, vous poserez une base solide pour les mathématiques avancées et leurs applications dans la vie réelle.

        ### Application pratique
        L\'algèbre est utilisée dans de nombreux domaines tels que la finance, l\'ingénierie et l\'informatique pour résoudre des problèmes et optimiser les résultats.
        ');
        $manager->persist($tutorial1);

        $tutorial2 = new Tutorial();
        $tutorial2->setTitle('Apprendre les bases de Python');
        $tutorial2->setDescription('Un cours intensif sur la programmation en Python.');
        $tutorial2->setCreationDate(new \DateTime('-1 year'));
        $tutorial2->setSubject($subject2);
        $tutorial2->setContent('
        ## Apprendre les bases de Python
        Python est un langage de programmation puissant et convivial pour les débutants. Dans ce tutoriel, vous apprendrez :
        - Les bases de la syntaxe Python.
        - Comment travailler avec des types de données simples comme les entiers, les chaînes de caractères et les listes.
        - Écrire et utiliser des fonctions simples.

        ### Pourquoi apprendre Python ?
        Python est polyvalent et largement utilisé dans des secteurs tels que le développement web, l\'analyse de données, l\'intelligence artificielle et l\'automatisation. Il est à la fois accessible pour les débutants et suffisamment puissant pour des cas d\'utilisation avancés.

        ### Premiers pas avec Python
        Python est réputé pour sa syntaxe claire et facile à lire. Voici un exemple de démarrage :

        ```python
        def saluer(nom):
            return "Bonjour, " + nom

        nom = "Alice"
        print(saluer(nom))
        ```

        Cette fonction simple prend un nom en entrée et retourne une salutation.

        ### Types de données en Python
        Python prend en charge divers types de données, notamment :
        - Chaînes : "Bonjour, le monde"
        - Entiers : 42
        - Listes : [1, 2, 3, 4]

        Exemple d\'utilisation d\'une liste :

        ```python
        ma_liste = [1, 2, 3]
        ma_liste.append(4)
        print(ma_liste)
        ```

        Cela affichera : [1, 2, 3, 4]

        ### Fonctions et logique
        Les fonctions en Python permettent d\'organiser votre code en blocs réutilisables. Voici un exemple :

        ```python
        def additionner(a, b):
            return a + b

        résultat = additionner(5, 7)
        print("Le résultat est :", résultat)
        ```

        Cela affichera : Le résultat est : 12

        ### Applications pratiques de Python
        Python est largement utilisé pour :
        - Automatiser des tâches répétitives.
        - Créer des sites web et des applications.
        - Analyser de grandes quantités de données.
        - Développer des modèles d\'apprentissage automatique.

        À la fin de ce tutoriel, vous aurez les bases nécessaires pour explorer la programmation en Python et l\'appliquer à des problèmes réels.
        ');
        $manager->persist($tutorial2);

        $tutorial3 = new Tutorial();
        $tutorial3->setTitle('Les lois du mouvement de Newton');
        $tutorial3->setDescription('Comprendre les lois de Newton avec des exemples.');
        $tutorial3->setCreationDate(new \DateTime('-1 year'));
        $tutorial3->setSubject($subject3);
        $tutorial3->setContent('
        ## Les lois du mouvement de Newton
        Les trois lois du mouvement d\'Isaac Newton constituent la base de la mécanique classique. Explorons-les :

        ### Première loi : La loi de l\'inertie
        Un objet reste au repos ou en mouvement uniforme à moins qu\'une force extérieure n\'agisse sur lui.

        ### Deuxième loi : F = ma
        La force est égale à la masse multipliée par l\'accélération. Cela signifie que la force appliquée à un objet est directement proportionnelle à sa masse et à son accélération.

        ### Troisième loi : Action et réaction
        Pour chaque action, il y a une réaction égale et opposée.

        ### Application pratique
        Les lois de Newton sont fondamentales pour concevoir des véhicules, comprendre la physique des sports et même planifier des missions spatiales.
        ');
        $manager->persist($tutorial3);



        // Chapters
        $chapter1 = new Chapter();
        $chapter1->setTitle('Qu\'est-ce que l\'algèbre ?');
        $chapter1->setContent('Une introduction à l\'algèbre, ses usages et son histoire.');
        $chapter1->setPosition(1);
        $chapter1->setTutorial($tutorial1);
        $manager->persist($chapter1);

        $chapter2 = new Chapter();
        $chapter2->setTitle('Opérations algébriques de base');
        $chapter2->setContent('Apprenez les opérations fondamentales en algèbre.');
        $chapter2->setPosition(2);
        $chapter2->setTutorial($tutorial1);
        $manager->persist($chapter2);

        $chapter3 = new Chapter();
        $chapter3->setTitle('Configurer Python');
        $chapter3->setContent('Comment installer et configurer Python sur votre système.');
        $chapter3->setPosition(1);
        $chapter3->setTutorial($tutorial2);
        $manager->persist($chapter3);


        // Commentaires
        $comment1 = new Comment();
        $comment1->setContent('Ce tutoriel est très utile !');
        $comment1->setCreationDate(new \DateTime('-1 year'));
        $comment1->setTutorial($tutorial1);
        $comment1->setUser($user1);
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setContent('J\'ai eu des difficultés avec l\'algèbre, mais ce tutoriel m\'a simplifié les choses.');
        $comment2->setCreationDate(new \DateTime('-1 year'));
        $comment2->setTutorial($tutorial2);
        $comment2->setUser($user2);
        $manager->persist($comment2);

        $manager->flush();
    }
}
