<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class SellController extends AbstractController
{
    #[Route('/sell', name: 'create_product')]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuteur($this->getUser());
            $article->setDatePublication(new \DateTimeImmutable());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'article ajouté');
        }
        return $this->render('sell/index.html.twig', [
            'article' => $form->createView(),
        ]);
    }


}
