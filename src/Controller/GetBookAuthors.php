<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/book/authors', name: 'app_book_authors')]
class GetBookAuthors
{
    public function __construct(private Environment $twig) {}

    public function __invoke(Request $request)
    {
        return new Response($this->twig->render('book/index.html.twig', [
            'controller_name' => self::class
        ]));
    }
}