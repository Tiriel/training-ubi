<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Security\Voter\BookVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book', name: 'app_book_')]
class BookController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    // #[Route('/{id}', name: 'details', requirements: ['id' => '\d+'], defaults: ['id' => 1], methods: ['GET'])]
    // #[Route('/{id<\d+>?1}', name: 'details', methods: ['GET'], condition: 'request.headers.get("My-Header") == "foo"')]
    #[Route('/{id<\d+>?1}', name: 'details', methods: ['GET'])]
    public function details(Book $book): Response
    {
        $this->denyAccessUnlessGranted(BookVoter::VIEW, $book);

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $book = new Book();
        $bookForm = $this->createForm(BookType::class, $book);

        return $this->renderForm('book/new.html.twig', [
            'book_form' => $bookForm,
        ]);
    }
}
