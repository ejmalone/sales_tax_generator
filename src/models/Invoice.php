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

        var_dump('will pretty print the order', $this->order);
        exit();
    }
}
