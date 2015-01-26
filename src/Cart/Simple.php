<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Cart;

use Indigo\Cart\Cart;
use Indigo\Cart\Item;
use Indigo\Cart\TotalCalculator;
use Indigo\Cart\Exception\ItemNotFound;

/**
 * Proof of concept Cart implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Simple implements Cart, \IteratorAggregate
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var Item[]
     */
    protected $items = [];

    /**
     * @param mixed $id
     * @param array $items
     */
    public function __construct($id = null, array $items = [])
    {
        $this->id = $id;

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->id = uniqid('__CART__');
        }

        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($id)
    {
        if (!$this->hasItem($id)) {
            throw new ItemNotFound($id);
        }

        return $this->items[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($id)
    {
        return array_key_exists($id, $this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(Item $item)
    {
        $id = $item->getId();

        if ($this->hasItem($id)) {
            $currentItem = $this->getItem($id);
            $currentItem->changeQuantity($item->getQuantity());

            return;
        }

        $this->items[$id] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem($id)
    {
        if ($this->hasItem($id)) {
            unset($this->items[$id]);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        // Null initial value is used for TotalCalculator
        // It is casted to integer when TotalCalculator is not used
        $total = null;

        foreach ($this->items as $item) {
            if ($item instanceof TotalCalculator) {
                $total = $item->calculateTotal($total);

                continue;
            }

            $total += $item->getSubtotal();
        }

        return $total;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        $totalQuantity = array_map(function ($item) {
            return $item->getQuantity();
        }, $this->items);

        return array_sum($totalQuantity);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->items = [];

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}
