<?php

namespace spec\Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Reference;

class ReferenceFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dolmen\Bundle\DolmenBundle\DependencyInjection\Factory\ReferenceFactory');
    }

    function it_create_new_reference_instance()
    {
        $this->create('some id')->shouldReturnReferenceOf('some id');
    }

    function getMatchers()
    {
        return [
            'returnReferenceOf' => function ($subject, $id) {
                return $subject instanceof Reference && (string)$subject === $id;
            }
        ];
    }
}
