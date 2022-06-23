<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Transformer\MovieTransformer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MovieProvider
{
    public function __construct(
        private MovieRepository $movieRepository,
        private OMDbApiConsumer $consumer,
        private MovieTransformer $transformer,
        private TokenStorageInterface $storage
    ) {}

    public function getMovieByTitle(string $title)
    {
        $movie = $this->movieRepository->findByLowerTitle($title) ??
            $this->transformer->arrayToEntity(
                $this->consumer->getMovieByTitle($title)
            );

        if (!$movie->getId()) {
            $this->movieRepository->add($movie, true);
        }

        return $movie;
    }

    public function getMovieById(string $id): Movie
    {
        $movie = $this->movieRepository->findOneBy(['imdbId' => $id]) ??
            $this->transformer->arrayToEntity(
                $this->consumer->getMovieById($id)
            );

        if (!$movie->getId()) {
            $this->addUserToMovie($movie);
            $this->movieRepository->add($movie, true);
        }

        return $movie;
    }

    public function addUserToMovie(Movie $movie): void
    {
        if (!$this->storage->getToken() || !$user = $this->storage->getToken()->getUser()){
            return;
        }

        if ($user instanceof User) {
            $movie->setAddedBy($user);
        }
    }
}