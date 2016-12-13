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

    public function pp() {

        foreach ($this->order->getOrderItems() as $orderItem) {

            $product = $orderItem->getProduct();

            echo "{$orderItem->getQuantity()} {$product->getName()}: {$product->getPrice()}\n";
        }

        echo "\n";

        echo "Sales Taxes: {$this->order->allTaxes()}\n";
        echo "Total: {$this->order->totalAmount()}\n";
        
    }
}
