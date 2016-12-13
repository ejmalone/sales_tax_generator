<?php

namespace models;

use models\Product;

class OrderItem {
    
    /** 
     * @var int positive number of products in this order item
     */
    private $quantity;
    
    /**
     * @var Product
     */
    private $product;

    public function __construct() {

    }

    /**
     * Assign product and quantity of product for use in an Order
     * 
     * @param models\Product $product
     * @param int $quantity must be >= 1
     *
     * @throws InvalidArgumentException if quantity is invalid 
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

    /**
     * Calculates the subtotal for this order item, given price and quantity
     *
     * @return float
     */
    function subtotal() {
        
        return round($this->quantity * $this->product->getPrice(), 2);
    }

    /**
     * Calculates the total tax amount, given product's taxes and quantity
     *
     * @return float
     */
    function totalTax() {
        
        // only rounding here to keep our tests happy (e.g. 4.20000 to 4.20)
        return round($this->quantity * $this->product->totalTaxes(), 2);
    }
}
