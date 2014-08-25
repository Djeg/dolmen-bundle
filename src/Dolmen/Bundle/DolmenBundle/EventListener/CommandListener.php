<?php

namespace Dolmen\Bundle\DolmenBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Listen to the kernel.request symfony2 event and handle the command launchment.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class CommandListener
{
    /**
     * Catch all the "dolmen" routes and redirect to the dolmen frontend
     * controller.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->attributes->has('_dolmen')) {
            return;
        }

        $request->attributes->set('_controller', 'dolmen.launcher.command_launcher:launch');
    }
}
