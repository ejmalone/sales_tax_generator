<?php

namespace models;

use models\Product;
use traits\ProductValidation;

class OrderItem {
    
    use ProductValidation;

    private $quantity;

    private $product;

    public function __construct() {

    }

    /**
     * Assign product and quantity of product for use in an Order
     * 
     * @param models\Product $product
     * @param int $quantity must be >= 1
     *
     * @throws InvalidArgumentException if either are invalid
     */
    public function setProductAndQuantity($product, $quantity) {
    
        $this->validateProduct($product);
        $this->validateQuantity($quantity);

        $this->product  = $product;
        $this->quantity = $quantity;
    }

    function validateQuantity($quantity) {
        
        if (!is_int($quantity)) {
            throw new \InvalidArgumentException(
                sprintf('passed quantity is not an integer, is a %s', gettype($quantity)));
        }

        if ($quantity <= 0) {
            throw new \InvalidArgumentException(
                sprintf('passed quantity amount is invalid, is %i', $quantity));
        }

    }
}
