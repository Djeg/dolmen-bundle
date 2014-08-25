<?php

namespace Dolmen\Bundle\DolmenBundle\EventListener;

use Dolmen\Bundle\DolmenBundle\Registry\ViewRegistry;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Dolmen\Context\Contextable;
use Dolmen\Exception\ViewNotFoundException;
use Dolmen\View\Renderer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Listen and render a given view.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ViewListener
{
    /**
     * @var ViewRegistry
     */
    private $registry;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @param ViewRegistry $registry
     */
    public function __construct(ViewRegistry $registry, Renderer $renderer)
    {
        $this->registry = $registry;
        $this->renderer = $renderer;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     *
     * @throws ViewNotFoundException
     * @throws \InvalidArgumentException
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $context = $event->getControllerResult();
        if (!$context instanceof Contextable) {
            return;
        }

        $rawView = $event->getRequest()->attributes->get('_view');

        if (null === $rawView) {
            // try to retrieve the raw view from the context
            if (!$context->has('_view')) {
                throw new ViewNotFoundException('No raw view ("_view") has been found inside the request attributes or in the context');
            }

            $rawView = $context->get('_view');
        }

        $rawView = $this->parseRawView($rawView);
        $view    = $this->registry->get($rawView['type']);
        $result  = $this->renderer->render($view, $context, $rawView['options']);

        if (!$result instanceof Response) {
            $result = new Response($result);
        }

        $event->setResponse($result);
    }

    public function parseRawView($rawView)
    {
        // convert the raw view in array
        if (is_string($rawView)) {
            $rawView = [
                'type'    => $rawView,
                'options' => []
            ];
        } else if (!is_array($rawView)) {
            $rawView = (array)$rawView;
        }

        // ensure the existence of the 'type'
        if (!isset($rawView['type'])) {
            throw new \InvalidArgumentException(
                'A _view definition should have a type.'
            );
        }

        // create empty options if not set
        if (!isset($rawView['options'])) {
            $rawView['options'] = [];
        }

        return $rawView;
    }
}
