<?php

namespace App\Event;

use App\Entity\Movie;
use Symfony\Contracts\EventDispatcher\Event;

class MovieEvent extends Event
{
    public const VIEW = 'movie.view';

    public function __construct(private Movie $movie){}

    public function getMovie(): Movie
    {
        return $this->movie;
    }
}