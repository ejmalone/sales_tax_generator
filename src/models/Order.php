<?php

namespace models;

use models\OrderItem;

class Order {
    
    /**
     * @var OrderItem[]
     */
    private $orderItems;

    public function __construct() {
        
        $this->orderItems = [];
    }

    public function addOrderItem($orderItem) {
    
        $this->validateInstanceOf($orderItem, 'models\OrderItem', 'orderItem');
        $this->orderItems[] = $orderItem;
    }

    public function getOrderItems() {
        return $this->orderItems;
    }

    public function subtotal() {
        
        $subtotal = 0.0;

        foreach ($this->orderItems as $orderItem) {
            $subtotal += $orderItem->subtotal();
        }

        return $subtotal;
    }

    public function allTaxes() {
        
        $taxes = 0.0;

        foreach ($this->orderItems as $orderItem) {
            $taxes += $orderItem->totalTax();
        }

        return $taxes;
    }

    public function totalAmount() {
        
        return $this->subtotal() + $this->allTaxes();
    }

    /**
     * Given an array parsed from JSON, build an order
     *
     * @param array $jsonArray
     */
    public static function buildFromJsonArray($jsonArray) {
       
        if (empty($jsonArray['items']) || !is_array($jsonArray['items'])) {
            throw new \InvalidArgumentException("json array argument must be an array with items index");
        }
        
        $order = new Order();

        foreach ($jsonArray['items'] as $item) {

            $product = new Product();
            $product->initialize($item);

            $orderItem = new OrderItem();
            $orderItem->setProductAndQuantity($product, $item['quantity']);

            $order->addOrderItem($orderItem);
        }

        return $order;
    }
}
