<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChaptersController extends AbstractController
{
    #[Route('/chapters', name: 'app_chapters')]
    public function index(): Response
    {
        return $this->render('chapters/index.html.twig', [
            'controller_name' => 'ChaptersController',
        ]);
    }
}
