<?php

namespace spec\Indigo\Cart\Item;

use PhpSpec\ObjectBehavior;

class SimpleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Item', 1, 1, '_ITEM_');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Cart\Item\Simple');
        $this->shouldUseTrait('Indigo\Cart\Quantity');
    }

    function it_is_an_item()
    {
        $this->shouldImplement('Indigo\Cart\Item');
    }

    function it_throws_an_exception_when_price_is_not_numeric()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['Item', 'asd', 1]);
    }

    function it_has_an_id()
    {
        $this->beConstructedWith('Item', 1, 1);
        $this->getId()->shouldBeString();
    }

    function it_has_a_custom_id()
    {
        $this->getId()->shouldReturn('_ITEM_');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('Item');
    }

    function it_has_a_price()
    {
        $this->getPrice()->shouldReturn(1);
    }

    function it_has_a_subtotal()
    {
        $this->getSubtotal()->shouldReturn(1);
    }

    public function getMatchers()
    {
        return [
            'useTrait' => function ($subject, $trait) {
                return class_uses($subject, $trait);
            }
        ];
    }
}
