<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tutorial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $username = $user ? $user->getUserIdentifier() : 'Anonyme';

        $tutorials = $entityManager->getRepository(Tutorial::class)->findAll();

        return $this->render('index.html.twig', [
            'username' => $username,
            'tutorials' => $tutorials,
        ]);
    }
}
