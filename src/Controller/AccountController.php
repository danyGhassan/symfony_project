<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //recup l'utilisateur
        $user = $entityManager->getRepository(User::class)->find($this->getUser());

        $articles = $user->getArticles();

        // Passer l'article à Twig
        return $this->render('account/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
