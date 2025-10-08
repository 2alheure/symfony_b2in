<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController {
    #[IsGranted('ROLE_ADMIN')] // Seul un utilisateur avec le rôle ROLE_ADMIN peut accéder à cette route
    #[Route('/article/create', name: 'app_article')]
    public function index(EntityManagerInterface $em, Request $request): Response {

        // $this->isGranted('ROLE_ADMIN'); // Vérifie que l'utilisateur a le rôle ROLE_ADMIN (boolean)

        $this->getUser(); // Récupère l'utilisateur actuellement connecté

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            return new Response('Article créé avec succès !');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_show')]
    public function show(Article $article, ArticleRepository $ar): Response {
        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/articles', name: 'app_article_list')]
    public function list(ArticleRepository $ar): Response {
        $articles = $ar->findAll();

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }
}
