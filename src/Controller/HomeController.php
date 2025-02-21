<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(ArticleRepository $articleRepository): Response
    {
        $latestArticles = $articleRepository->findLatestArticles();

        return $this->render('home/index.html.twig', [
            'articles' => $latestArticles,
        ]);
    }
}
