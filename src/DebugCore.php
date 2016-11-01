<?php

namespace Jarvis\Skill\Debug;

use Jarvis\Jarvis;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;
use Jarvis\Skill\EventBroadcaster\BroadcasterInterface;
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
        if ($jarvis['debug']) {
            Debug::enable();

            $jarvis->on(BroadcasterInterface::EXCEPTION_EVENT, function (ExceptionEvent $event) {
                if (!($event->exception() instanceof \Exception)) {
                    return;
                }

                $response = new Response(
                    (new ExceptionHandler())->getHtml($event->exception()),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );

                $event->setResponse($response);
            });
        }
    }
}
