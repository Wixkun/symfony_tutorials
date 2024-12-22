<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        // Vérifie si l'utilisateur a le rôle ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Accès refusé.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/admin.html.twig');
    }

    #[Route('/admin/users', name: 'admin_users', methods: ['GET'])]
    public function manageUsers(): Response
    {
        // Exemple : Liste des utilisateurs (à implémenter)
        return $this->render('admin/users.html.twig', [
            // 'users' => ... (récupérez la liste des utilisateurs ici)
        ]);
    }

    #[Route('/admin/tutorials', name: 'admin_tutorials', methods: ['GET'])]
    public function manageTutorials(): Response
    {
        // Exemple : Liste des tutoriels (à implémenter)
        return $this->render('admin/tutorials.html.twig', [
            // 'tutorials' => ... (récupérez la liste des tutoriels ici)
        ]);
    }

    #[Route('/admin/stats', name: 'admin_stats', methods: ['GET'])]
    public function viewStats(): Response
    {
        // Exemple : Statistiques (à implémenter)
        return $this->render('admin/stats.html.twig', [
            // 'stats' => ... (récupérez les statistiques ici)
        ]);
    }
}
