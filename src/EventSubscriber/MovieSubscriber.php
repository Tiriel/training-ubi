<?php

namespace App\EventSubscriber;

use App\Event\MovieEvent;
use App\Notifier\NotificationHandler;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class MovieSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private NotificationHandler $handler,
        private UserRepository $userRepository
    ) {}

    public function onMovieView(MovieEvent $event): void
    {
        $movie = $event->getMovie();
        if (in_array($movie->getRated(), ['NC-17', 'R'])) {
            $users = $this->userRepository->findAdmins();

            /***
            $this->handler->sendNotification(
                'mail',
                sprintf("The movie \"%s\" is being watched!", $movie->getTitle()),
                $users
            );
             */
            dump(sprintf('Movie: "%s"', $movie->getTitle()));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieEvent::VIEW => 'onMovieView',
        ];
    }
}
