<?php

namespace Jarvis\Skill\Debug;

use Jarvis\Jarvis;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;
use Jarvis\Skill\EventBroadcaster\JarvisEvents;
use Jarvis\Skill\EventBroadcaster\ExceptionEvent;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ExceptionHandler;

/**
 * @author Eric Chau <eric.chau@gmail.com>
 */
class ContainerProvider implements ContainerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $jarvis)
    {
        if ($jarvis->debug) {
            Debug::enable();

            $jarvis->addReceiver(JarvisEvents::EXCEPTION_EVENT, function (ExceptionEvent $event) {
                $event->setResponse((new ExceptionHandler())->createResponse($event->exception()));
            });
        }
    }
}
