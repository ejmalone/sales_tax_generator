<?php

namespace models;

use models\Order;
use models\OrderItem;
use traits\Validation;

class Invoice {
    
    use Validation;
    
    private $order;
    
    public function __construct() {
        
        $this->order = null;
    }

    public function setOrder($order) {

        $this->validateInstanceOf($order, 'models\Order', 'order');
    
        $this->order = $order;
    }

    public function format(float $value) {
        
        return number_format($value, 2);
    }

    public function pp() {

        foreach ($this->order->getOrderItems() as $orderItem) {

            $product = $orderItem->getProduct();

            echo "{$orderItem->getQuantity()} {$product->getName()}: {$this->format($product->taxablePrice())}\n";
        }

        echo "\n";

        echo "Sales Taxes: {$this->format($this->order->allTaxes())}\n";
        echo "Total: {$this->format($this->order->totalAmount())}\n";
        
    }
}
