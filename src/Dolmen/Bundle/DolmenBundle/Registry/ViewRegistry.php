<?php

namespace Dolmen\Bundle\DolmenBundle\Registry;

use Dolmen\View\ViewableContext;

/**
 * Store all the different views.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ViewRegistry
{
    /**
     * @var array
     */
    private $views;

    public function __construct()
    {
        $this->views = [];
    }

    /**
     * @param ViewableContext $view
     */
    public function add(ViewableContext $view)
    {
        $this->views[$view->getName()] = $view;

        return $this;
    }

    /**
     * @param string $viewName
     *
     * @throws \InvalidArgumentException
     *
     * @return ViewableContext
     */
    public function get($viewName)
    {
        if (!$this->has($viewName)) {
            throw new \InvalidArgumentException(sprintf(
                'The view named %s is not stored inside the view registry.',
                $viewName
            ));
        }

        return $this->views[$viewName];
    }

    /**
     * @param string $viewName
     *
     * @return boolean
     */
    public function has($viewName)
    {
        return isset($this->views[$viewName]);
    }
}
