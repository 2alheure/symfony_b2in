<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ContactController extends AbstractController {
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = new Email;
            $email
                ->from($data['email'])
                ->to('contact@mon-site.com')
                ->subject($data['sujet'])
                ->text('Quelqu\'un vous a contacté via le formulaire en ligne. Voici le message : ' . PHP_EOL . $data['contenu']);

            $mailer->send($email);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
