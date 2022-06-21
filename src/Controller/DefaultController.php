<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'app_default_')]
class DefaultController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'Index',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request$request): Response
    {
        $contactForm = $this->createForm(ContactType::class, []);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // ...

            return $this->redirectToRoute('app_default_index');
        }

        return $this->renderForm('default/contact.html.twig', [
            'contact_form' => $contactForm,
        ]);
    }
}
