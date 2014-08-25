<?php

namespace Dolmen\Bundle\DolmenBundle\Launcher;

use Symfony\Component\HttpFoundation\Request;
use Dolmen\Command\Launcher\Launchable;
use Dolmen\Context\Contextable;
use Dolmen\Context\Context;

/**
 * Launch a suit of commands store in the request.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class CommandLauncher
{
    /**
     * @var Launchable
     */
    private $launcher;

    /**
     * @var Contextable
     */
    private $context;

    /**
     * @param Launchable  $launcher
     * @param Contextable $context
     */
    public function __construct(Launchable $launcher, Contextable $context = null)
    {
        $this->launcher = $launcher;
        $this->context  = $context ?: new Context;
    }

    /**
     * Launch the suit of command that the request contains. You can store
     * commands name inside the "_commands" attributes of the request.
     *
     * @param Request $request
     */
    public function launch(Request $request)
    {
        // set up the request inside the context
        $this->context->set('request', $request);

        $commands = (array)$request->attributes->get('_commands');

        if (empty($commands)) {
            // No commands seems to exists, return a 404 error
            throw new NotFoundHttpException(sprintf(
               'No commands has been found for the current route : %s',
                $request->attributes->get('_route')
            ));
        }

        foreach ($commands as $command) {
            $this->launcher->launch($command, $this->context);
        }

        // Finaly return a context that will be treat by the view listener
        return $this->context;
    }
}
