<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function show_cart(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer les IDs des articles et leurs quantités dans la session
        $cart = $request->getSession()->get('cart', []);

        // Récupérer les articles à partir de la base de données
        $articlesInCart = $entityManager->getRepository(Article::class)->findBy([
            'id' => array_keys($cart),
        ]);

        // Calculer le total du panier
        $total = 0;
        foreach ($articlesInCart as $article) {
            $quantity = $cart[$article->getId()];
            $total += $article->getPrix() * $quantity;
        }

        return $this->render('cart/index.html.twig', [
            'articles' => $articlesInCart,
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add_to_cart(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer l'article
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        // Récupérer le panier existant
        $cart = $request->getSession()->get('cart', []);
        $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1; // Incrémente la quantité si l'article est déjà dans le panier
        $request->getSession()->set('cart', $cart); // Sauvegarder le panier dans la session

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove_from_cart(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer le panier existant
        $cart = $request->getSession()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]); // Supprimer l'article du panier
        }
        $request->getSession()->set('cart', $cart); // Sauvegarder le panier dans la session

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/update/{id}/{quantity}', name: 'app_cart_update')]
    public function update_cart_quantity(int $id, int $quantity, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer le panier existant
        $cart = $request->getSession()->get('cart', []);

        // Si la quantité est valide (non négative)
        if ($quantity > 0) {
            $cart[$id] = $quantity; // Mettre à jour la quantité de l'article
        } else {
            unset($cart[$id]); // Si la quantité est zéro ou négative, on retire l'article du panier
        }

        $request->getSession()->set('cart', $cart); // Sauvegarder le panier dans la session

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/checkout', name: 'app_cart_checkout')]
    public function checkout(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $cart = $request->getSession()->get('cart', []);

        if (empty($cart)) {
            return $this->redirectToRoute('app_cart');
        }

        // Calculer le total du panier
        $total = 0;
        foreach ($cart as $id => $quantity) {
            $article = $entityManager->getRepository(Article::class)->find($id);
            if ($article) {
                $total += $article->getPrix() * $quantity;
            }
        }

        // Vérifier si l'utilisateur a suffisamment de solde
        if ($user->getSolde() >= $total) {
            // Déduire le montant du solde
            $user->setSolde($user->getSolde() - $total);
            $entityManager->flush();

            // Vider le panier
            $request->getSession()->remove('cart');

            return $this->render('cart/checkout_success.html.twig');
        } else {
            return $this->render('cart/checkout_error.html.twig', [
                'message' => 'Solde insuffisant.',
            ]);
        }
    }
}

