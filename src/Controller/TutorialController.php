<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tutorial;
use App\Entity\Chapter;
use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;
use League\CommonMark\CommonMarkConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TutorialController extends AbstractController
{
    #[Route(path: '/tutorial/{id}', name: 'tutorial_show', requirements: ['id' => '\\d+'], methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $tutorial = $entityManager->getRepository(Tutorial::class)->find($id);

        if (!$tutorial) {
            throw $this->createNotFoundException('Le tutoriel demandé est introuvable.');
        }

        $chapters = $entityManager->getRepository(Chapter::class)->findBy(['tutorial' => $tutorial]);
        $subject = $tutorial->getSubject();

        $converter = new CommonMarkConverter();
        $contentHtml = $converter->convertToHtml($tutorial->getContent());

        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
            'chapters' => $chapters,
            'subject' => $subject,
            'contentHtml' => $contentHtml, 
        ]);
    }
}
