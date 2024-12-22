<?php

namespace App\Controller\Admin;

use App\Entity\Tutorial;
use App\Form\TutorialType;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tutorial')]
final class TutorialController extends AbstractController
{
    #[Route(name: 'app_admin_tutorial_index', methods: ['GET'])]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        return $this->render('admin/tutorial/index.html.twig', [
            'tutorials' => $tutorialRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tutorial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tutorial = new Tutorial();
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tutorial);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tutorial/new.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tutorial_show', methods: ['GET'])]
    public function show(Tutorial $tutorial): Response
    {
        return $this->render('admin/tutorial/show.html.twig', [
            'tutorial' => $tutorial,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tutorial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tutorial $tutorial, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tutorial/edit.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tutorial_delete', methods: ['POST'])]
    public function delete(Request $request, Tutorial $tutorial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tutorial->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tutorial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_tutorial_index', [], Response::HTTP_SEE_OTHER);
    }
}
