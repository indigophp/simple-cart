<?php

namespace spec\Indigo\Cart\Cart;

use Indigo\Cart\Item;
use PhpSpec\ObjectBehavior;

class SimpleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Cart\Cart\Simple');
        $this->shouldImplement('IteratorAggregate');
    }

    function it_is_a_cart()
    {
        $this->shouldImplement('Indigo\Cart\Cart');
    }

    function it_has_an_id()
    {
        $this->getId()->shouldBeString();
    }

    function it_has_a_custom_id()
    {
        $this->beConstructedWith('_CART_');

        $this->getId()->shouldReturn('_CART_');
    }

    function it_instantiates_with_items(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');
        $this->beConstructedWith('_CART_', [$item]);

        $this->hasItem('_ITEM_')->shouldReturn(true);
    }

    function it_has_items(Item $item, Item $anotherItem)
    {
        $item->getId()->willReturn('_ITEM_');
        $anotherItem->getId()->willReturn('_ANOTHER_ITEM_');
        $this->beConstructedWith('_CART_', [$item]);

        $this->addItem($anotherItem);

        $this->hasItem('_ITEM_')->shouldReturn(true);
        $this->hasItem('_ANOTHER_ITEM_')->shouldReturn(true);
        $this->getItem('_ANOTHER_ITEM_')->shouldReturn($anotherItem);
        $this->getItems()->shouldReturn([
            '_ITEM_'         => $item,
            '_ANOTHER_ITEM_' => $anotherItem,
        ]);

        $this->shouldThrow('Indigo\Cart\Exception\ItemNotFound')->duringGetItem('_NON_EXISTENT_');
    }

    function it_adds_an_item(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');

        $this->addItem($item);

        $this->hasItem('_ITEM_')->shouldReturn(true);
    }

    function it_updates_an_item(Item $item)
    {
        $item->getId()->willReturn('_ITEM_')->shouldBeCalled(2);
        $item->getQuantity()->willReturn(1);
        $item->changeQuantity(1)->shouldBeCalled();

        $this->addItem($item);
        $this->addItem($item);

        $this->hasItem('_ITEM_')->shouldReturn(true);
    }

    function it_removes_an_item(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');

        $this->addItem($item);

        $this->removeItem('_ITEM_')->shouldReturn(true);
        $this->hasItem('_ITEM_')->shouldReturn(false);
    }

    function it_returns_false_when_item_is_not_present_during_removal()
    {
        $this->removeItem('_ITEM_')->shouldReturn(false);
    }

    function it_calculates_total(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');
        $item->getSubtotal()->willReturn(1);

        $this->addItem($item);

        $this->getTotal()->shouldReturn(1);
    }

    function it_calculate_total_using_total_calculator(Item $item)
    {
        $item->implement('Indigo\Cart\TotalCalculator');

        $item->getId()->willReturn('_ITEM_');
        $item->calculateTotal(null)->willReturn(2);

        $this->addItem($item);

        $this->getTotal()->shouldReturn(2);
    }

    function it_has_a_quantity(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');
        $item->getQuantity()->willReturn(1);

        $this->addItem($item);

        $this->getQuantity()->shouldReturn(1);
    }

    function it_is_empty_by_default()
    {
        $this->shouldBeEmpty();
    }

    function it_is_not_empty_when_items_added(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');

        $this->addItem($item);

        $this->shouldNotBeEmpty();
    }

    function it_clears_items(Item $item)
    {
        $item->getId()->willReturn('_ITEM_');

        $this->addItem($item);

        $this->clear()->shouldReturn(true);
        $this->isEmpty()->shouldBe(true);
    }

    function it_has_an_iterator()
    {
        $this->getIterator()->shouldHaveType('ArrayIterator');
    }

    function it_has_a_count()
    {
        $this->count()->shouldBe(0);
    }
}
