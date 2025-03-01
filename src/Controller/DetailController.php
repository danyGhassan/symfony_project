<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class DetailController extends AbstractController
{
    #[Route('/detail', name: 'app_detail')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function index(): Response
    {
        return $this->render('detail/index.html.twig', [
            'controller_name' => 'DetailController',
        ]);
    }
}
