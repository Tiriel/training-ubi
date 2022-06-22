<?php

namespace App\Transformer;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;

class MovieTransformer implements TransformerInterface
{
    public function __construct(
        private GenreRepository $repository
    ){}

    public function arrayToEntity(array $data): Movie
    {
        $date = $data['Released'] === 'N/A' ? $data['Year'] : $data['Released'];
        $genres = explode(', ', $data['Genre']);

        $movie = (new Movie())
            ->setTitle($data['Title'])
            ->setPoster($data['Poster'])
            ->setCountry($data['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPrice(5.0)
        ;

        foreach ($genres as $genre) {
            $genre = $this->repository->findOneBy(['name' => $genre]) ?? (new Genre())->setName($genre);
            $movie->addGenre($genre);
        }

        return $movie;
    }

    public function entityToArray(object $entity): array
    {
        // TODO: Implement entityToArray() method.
    }
}