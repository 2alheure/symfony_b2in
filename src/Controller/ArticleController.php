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

final class ArticleController extends AbstractController {
    #[Route('/article/create', name: 'app_article')]
    public function index(EntityManagerInterface $em, Request $request): Response {
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
