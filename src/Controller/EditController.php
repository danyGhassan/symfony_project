<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class EditController extends AbstractController
{
    #[Route('/edit', name: 'app_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function index(): Response
    {
        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
        ]);
    }
}
