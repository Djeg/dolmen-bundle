<?php

namespace spec\Dolmen\Bundle\DolmenBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Dolmen\Bundle\DolmenBundle\Registry\ViewRegistry;
use Dolmen\View\Renderer;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Dolmen\Context\Contextable;
use Symfony\Component\HttpFoundation\Response;
use Dolmen\View\ViewableContext;

class ViewListenerSpec extends ObjectBehavior
{
    function let(ViewRegistry $registry, Renderer $renderer)
    {
        $this->beConstructedWith($registry, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\EventListener\ViewListener');
    }

    function it_supports_only_contextable_request_result(
        GetResponseForControllerResultEvent $event
    ) {
        $event->getControllerResult()->shouldBeCalled()->willReturn('some non supported results');

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelView($event);
    }

    function it_does_not_support_non_existent_view(
        GetResponseForControllerResultEvent $event,
        Request $request,
        ParameterBag $attributes,
        Contextable $context
    ) {
        $request->attributes = $attributes;

        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $event->getControllerResult()->shouldBeCalled()->willReturn($context);

        $attributes->get('_view')->shouldBeCalled()->willReturn(null);
        $context->has('_view')->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('Dolmen\Exception\ViewNotFoundException')->duringOnKernelView($event);
    }

    function it_does_not_support_bad_named_view(
        GetResponseForControllerResultEvent $event,
        Request $request,
        ParameterBag $attributes,
        Contextable $context
    ) {
        $request->attributes = $attributes;
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $event->getControllerResult()->shouldBeCalled()->willReturn($context);

        $attributes->get('_view')->shouldBeCalled()->willReturn([
            'bad array'
        ]);

        $this->shouldThrow('InvalidArgumentException')->duringOnKernelView($event);
    }

    function it_render_the_view_and_return_a_response(
        GetResponseForControllerResultEvent $event,
        Request $request,
        ParameterBag $attributes,
        Contextable $context,
        Response $response,
        ViewableContext $view,
        $registry,
        $renderer
    ) {
        $event->getControllerResult()->shouldBeCalled()->willReturn($context);
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->attributes = $attributes;
        $attributes->get('_view')->shouldBeCalled()->willReturn([
            'name' => 'Some view',
            'options' => ['some options']
        ]);

        $registry->get('Some view')->shouldBeCalled()->willReturn($view);
        $renderer->render($view, $context, ['some options'])->shouldBeCalled()->willReturn($response);

        $event->setResponse($response)->shouldBeCalled();

        $this->onKernelView($event);
    }
}
