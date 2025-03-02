<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class EditController extends AbstractController
{
    #[Route('/edit/{id}', name: 'article_modification')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editArticle(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        // Créer le formulaire
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'L\'article a été mis à jour avec succès.');

            // Rediriger vers la page de l'article modifié (ou autre)
            return $this->redirectToRoute('app_account');
        }

        return $this->render('edit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
