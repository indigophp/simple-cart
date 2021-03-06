<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Store;

use Indigo\Cart\Store;
use Indigo\Cart\Cart;
use Indigo\Cart\Exception\CartNotFound;

/**
 * Stores carts in native session
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Session implements Store
{
    /**
     * Session key used for store
     *
     * @var string
     */
    protected $sessionKey;

    /**
     * Creates a new SessionStore
     *
     * @param string $sessionKey
     */
    public function __construct($sessionKey = 'cart')
    {
        $this->sessionKey = $sessionKey;

        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = [];
        }
    }

    /**
     * Returns the session key
     *
     * @return string
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        if (isset($_SESSION[$this->sessionKey][$id])) {
            return $_SESSION[$this->sessionKey][$id];
        }

        throw new CartNotFound($id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Cart $cart)
    {
        $id = $cart->getId();

        $_SESSION[$this->sessionKey][$id] = $cart;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        if (isset($_SESSION[$this->sessionKey][$id])) {
            unset($_SESSION[$this->sessionKey][$id]);

            return true;
        }

        return false;
    }
}
