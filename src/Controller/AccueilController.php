<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController {

    #[Route('/')]
    public function index() {

        $cdj = rand(1, 100);

        return $this->render('accueil.html.twig', [
            'chiffre_du_jour' => $cdj
        ]);
    }
}
