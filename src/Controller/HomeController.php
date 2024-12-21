<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->getUser();

        $username = $user ? $user->getUserIdentifier() : 'Anonyme';

        return $this->render('index.html.twig', [
            'username' => $username,
        ]);
    }
}
