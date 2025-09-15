<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController {
    #[Route('/article/create', name: 'app_article')]
    public function index(EntityManagerInterface $em): Response {
        for ($i = 0 ; $i < 10000 ; $i++) {
            $article = new Article();
            $article->setTitre('My First Article');
            $article->setContenu('This is the content of my first article.');
            $article->setImg('https://example.com/image.jpg');
            $article->setDate(new \DateTime());
            $em->persist($article);
        }

        $em->flush();

        return new Response('Article created with ID: ' . $article->getId());
    }

    #[Route('/articles', name: 'app_article_list')]
    public function list(ArticleRepository $ar): Response {
        $articles = $ar->findAll();

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

}
