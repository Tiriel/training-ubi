<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Repository\MovieRepository;
use App\Transformer\MovieTransformer;

class MovieProvider
{
    public function __construct(
        private MovieRepository $movieRepository,
        private OMDbApiConsumer $consumer,
        private MovieTransformer $transformer
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
}