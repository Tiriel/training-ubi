<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Event\MovieEvent;
use App\Provider\MovieProvider;
use App\Security\Voter\MovieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'app_movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/{title}', name: 'details')]
    public function details(string $title, MovieProvider $provider, EventDispatcherInterface $dispatcher): Response
    {
        $movie = $provider->getMovieByTitle($title);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        $dispatcher->dispatch(new MovieEvent($movie), MovieEvent::VIEW);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
