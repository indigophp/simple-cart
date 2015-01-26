<?php

namespace spec\Indigo\Cart\Store;

use Indigo\Cart\Cart;
use PhpSpec\ObjectBehavior;

class SessionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Cart\Store\Session');
    }

    function it_is_a_store()
    {
        $this->shouldImplement('Indigo\Cart\Store');
    }

    function it_has_a_session_key()
    {
        $this->beConstructedWith('SESSION_KEY');

        $this->getSessionKey()->shouldReturn('SESSION_KEY');
    }

    function it_finds_an_existing_cart(Cart $cart)
    {
        $cart->getId()->willReturn('cart_id');

        $this->save($cart)->shouldReturn(true);

        $this->find('cart_id')->shouldReturn($cart);
    }

    function it_throws_an_exception_when_cart_cannot_be_found()
    {
        $this->shouldThrow('Indigo\Cart\Exception\CartNotFound')->duringFind('non_existent_cart_id');
    }

    function it_saves_a_cart(Cart $cart)
    {
        $cart->getId()->willReturn('cart_id');

        $this->save($cart)->shouldReturn(true);
    }

    function it_deletes_a_cart()
    {
        $this->delete('non_existent_cart_id')->shouldReturn(false);
    }

    function it_deletes_an_existing_cart(Cart $cart)
    {
        $cart->getId()->willReturn('cart_id');

        $this->save($cart)->shouldReturn(true);

        $this->delete('cart_id')->shouldReturn(true);
    }
}
