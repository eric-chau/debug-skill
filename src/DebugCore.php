<?php

namespace Jarvis\Skill\Debug;

use Jarvis\Jarvis;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;
use Jarvis\Skill\EventBroadcaster\JarvisEvents;
use Jarvis\Skill\EventBroadcaster\ExceptionEvent;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Eric Chau <eric.chau@gmail.com>
 */
class DebugCore implements ContainerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $jarvis)
    {
        if ($jarvis->debug) {
            Debug::enable();

            $jarvis->addReceiver(JarvisEvents::EXCEPTION_EVENT, function (ExceptionEvent $event) {
                $response = new Response(
                    (new ExceptionHandler())->getHtml($event->exception()),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );

                $event->setResponse($response);
            });
        }
    }
}
