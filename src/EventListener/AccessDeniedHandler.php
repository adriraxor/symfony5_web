<?php

// src/EventListener/AccessDeniedListener.php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedHandler implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof AccessDeniedException) {
            return;
        }

        // ... perform some action (e.g. logging)


        // optionally set the custom response
        $event->setResponse(new Response("<title>Access Denied</title><style>body{background-color: #3a274e; font-family: 'Patua One', cursive;}</style><div class='' style='margin-top: 20%; text-align: center;color: red;'><h1>Page uniquement réservé aux administrateurs, vous n'avez pas l'autorisation !</h1><h3>\$error 15$</h3></div></body>", 403));


        // or stop propagation (prevents the next exception listeners from being called)
        //$event->stopPropagation();
    }
}
