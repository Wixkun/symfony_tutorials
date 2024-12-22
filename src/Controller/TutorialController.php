<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tutorial;
use App\Entity\Chapter;
use App\Entity\Subject;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use League\CommonMark\CommonMarkConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TutorialController extends AbstractController
{
    #[Route(path: '/tutorial/{id}', name: 'tutorial_show', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    public function show(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $tutorial = $entityManager->getRepository(Tutorial::class)->find($id);

        if (!$tutorial) {
            throw $this->createNotFoundException('Le tutoriel demandé est introuvable.');
        }

        $chapters = $entityManager->getRepository(Chapter::class)->findBy(['tutorial' => $tutorial]);
        $subject = $tutorial->getSubject();
        $comments = $tutorial->getComments();

        $converter = new CommonMarkConverter();
        $contentHtml = $converter->convertToHtml($tutorial->getContent());

        $editingCommentId = $request->query->getInt('edit_comment_id', 0); // Récupère l'ID du commentaire à modifier, 0 par défaut

        $newComment = new Comment();
        $newComment->setTutorial($tutorial);
        $newComment->setUser($this->getUser());
        $form = $this->createForm(CommentType::class, $newComment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newComment->setCreationDate(new \DateTime());

            $entityManager->persist($newComment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');

            return $this->redirectToRoute('tutorial_show', ['id' => $id]);
        }

        $commentForms = [];
        foreach ($comments as $comment) {
            $commentForms[$comment->getId()] = $this->createForm(CommentType::class, $comment)->createView();
        }

        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'chapters' => $chapters,
            'subject' => $subject,
            'comments' => $comments,
            'contentHtml' => $contentHtml,
            'form' => $form->createView(),
            'commentForms' => $commentForms,
            'editingCommentId' => $editingCommentId,
        ]);
    }

    #[Route(path: '/comment/{id}/edit', name: 'comment_edit', methods: ['POST'])]
    public function editComment(
        int $id, 
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Commentaire introuvable.');
        }

        if ($this->getUser() !== $comment->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres commentaires.');
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire mis à jour avec succès.');
        }

        return $this->redirectToRoute('tutorial_show', ['id' => $comment->getTutorial()->getId()]);
    }

    #[Route('/comment/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function deleteComment(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            if ($this->getUser() !== $comment->getUser()) {
                throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres commentaires.');
            }

            $entityManager->remove($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire supprimé avec succès.');
        }

        return $this->redirectToRoute('tutorial_show', ['id' => $comment->getTutorial()->getId()]);
    }
}
