<?php

namespace App\Controller\Admin;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/subject')]
final class SubjectController extends AbstractController
{
    #[Route(name: 'app_admin_subject_index', methods: ['GET'])]
    public function index(SubjectRepository $subjectRepository): Response
    {
        return $this->render('admin/subject/index.html.twig', [
            'subjects' => $subjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_subject_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_subject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/subject/new.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_subject_show', methods: ['GET'])]
    public function show(Subject $subject): Response
    {
        return $this->render('admin/subject/show.html.twig', [
            'subject' => $subject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_subject_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subject $subject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Matière mise à jour avec succès.');
    
            return $this->redirectToRoute('app_admin_subject_index');
        }
    
        return $this->render('admin/subject/edit.html.twig', [
            'subject' => $subject,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{id}', name: 'app_admin_subject_delete', methods: ['POST'])]
    public function delete(Request $request, Subject $subject, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subject->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_subject_index', [], Response::HTTP_SEE_OTHER);
    }
}
