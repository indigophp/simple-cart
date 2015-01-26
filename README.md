# Indigo Simple Cart

[![Latest Version](https://img.shields.io/github/release/indigophp/simple-cart.svg?style=flat-square)](https://github.com/indigophp/simple-cart/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/indigophp/simple-cart.svg?style=flat-square)](https://travis-ci.org/indigophp/simple-cart)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/indigophp/simple-cart.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/simple-cart)
[![Quality Score](https://img.shields.io/scrutinizer/g/indigophp/simple-cart.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/simple-cart)
[![HHVM Status](https://img.shields.io/hhvm/indigophp/simple-cart.svg?style=flat-square)](http://hhvm.h4cc.de/package/indigophp/simple-cart)
[![Total Downloads](https://img.shields.io/packagist/dt/indigophp/simple-cart.svg?style=flat-square)](https://packagist.org/packages/indigophp/simple-cart)
[![Dependency Status](https://img.shields.io/versioneye/d/php/indigophp:simple-cart.svg?style=flat-square)](https://www.versioneye.com/php/indigophp:simple-cart)

**Simple implementation of [Indigo Cart](https://github.com/indigophp/cart).**


## Install

Via Composer

``` bash
$ composer require indigophp/simple-cart
```


## Usage

``` php
use Indigo\Cart\Cart;
use Indigo\Cart\Item;
use Indigo\Cart\Store;

/* Note: these are interfaces, you cannot instantiate them */

$cart = new Cart\Simple;

// name, price, quentity [, id]
$cart->addItem(new Item\Simple('Item', 1, 1, '_ITEM_'));

// Get total price
$cart->getTotal();

// Get item count (item * quantity)
$cart->getQuantity();

foreach($cart->getItems() as $id => $item) {
    // Get subtotal
    $item->getSubtotal();

    // Get price
    $item->getPrice();

    // Get name
    $item->getName();
}

// Throws an Indigo\Cart\Exception\ItemNotFound
$cart->getItem('non_existent');

// Accepts a session key
$store = new Store\Session('cart');
$store->save($cart);
```

Get existing cart:

``` php
use Indigo\Cart\Store;

$store = new Store\Session('cart');
$cart = $store->find('cart_id');

// Throws an Indigo\Cart\Exception\CartNotFound
$store->find('non_existent');
```


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/indigophp/simple-cart/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
