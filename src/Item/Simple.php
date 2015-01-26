<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Item;

use Indigo\Cart\Item;
use Indigo\Cart\Quantity;
use Assert\Assertion;

/**
 * Simple Item
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Simple implements Item
{
    use Quantity;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var numeric
     */
    protected $price;

    /**
     * @param string  $name
     * @param numeric $price
     * @param integer $quantity
     * @param mixed   $id
     */
    public function __construct($name, $price, $quantity, $id = null)
    {
        Assertion::numeric($price);
        $this->setQuantity($quantity);

        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->id = md5(serialize([$this->name, $this->price]));
        }

        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}
