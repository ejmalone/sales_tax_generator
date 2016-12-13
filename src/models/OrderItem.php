<?php

namespace models;

use models\Product;

class OrderItem {
    
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
    public function setProductAndQuantity(Product $product, int $quantity) {
    
        if ($quantity <= 0) {
            throw new \InvalidArgumentException(
                sprintf('passed quantity amount is invalid, is %i', $quantity));
        }

        $this->product  = $product;
        $this->quantity = $quantity;
    }
    
    function getProduct() {
        
        return $this->product;
    }

    function getQuantity() {
        
        return $this->quantity;
    }

    function subtotal() {
        
        return round($this->quantity * $this->product->getPrice(), 2);
    }

    function totalTax() {
        
        // only rounding here to keep our tests happy (e.g. 4.20000 to 4.20)
        return round($this->quantity * $this->product->totalTaxes(), 2);
    }
}
