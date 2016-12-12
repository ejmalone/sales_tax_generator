<?php

require __DIR__ . '/../vendor/autoload.php';

use models\Product;

$p = new Product(array());

$p->subtotal();
