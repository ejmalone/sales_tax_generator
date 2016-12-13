<?php

namespace models;

use models\Order;
use models\OrderItem;

/**
 * Given an order, this class outputs the invoice of products,
 * taxes, and total amounts
 */
class Invoice {
    
    /**
     * @var Order
     */
    private $order;
    
    public function __construct() {
        
        $this->order = null;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order) {
    
        $this->order = $order;
    }


    /**
     * The printing of our invoice, echos to standard out
     */
    public function print() {

        foreach ($this->order->getOrderItems() as $orderItem) {

            $product = $orderItem->getProduct();

            echo "{$orderItem->getQuantity()} {$this->formattedName($product)}: " .
                 "{$this->formatFloat($product->taxablePrice())}\n";
        }

        echo "\n";

        echo "Sales Taxes: {$this->formatFloat($this->order->allTaxes())}\n";
        echo "Total: {$this->formatFloat($this->order->totalAmount())}\n";
        
    }

    /**
     * Formats the price to a string format per spec
     *
     * @param float $value
     * @return string
     */
    public function formatFloat(float $value) {
        
        return number_format($value, 2);
    }

    /**
     * Formats the name of a product for invoice display per spec
     *
     * @param Product $product
     * @return string the name of the product
     */
    public function formattedName(Product $product) {
        
        $buffer = '';

        if ($product->isImported())
            $buffer .= 'imported ';

        $buffer .= $product->getName();

        return $buffer;
    }
}
