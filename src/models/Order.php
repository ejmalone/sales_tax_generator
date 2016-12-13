<?php

namespace models;

use models\OrderItem;


/**
 * Aggregates OrderItems into a single Order
 */
class Order {
    
    /**
     * @var OrderItem[]
     */
    private $orderItems;

    public function __construct() {
        
        $this->orderItems = [];
    }

    /**
     * Adds an OrderItem to this order
     *
     * @param OrderItem $orderItem
     * @return void
     */
    public function addOrderItem(OrderItem $orderItem) {
    
        $this->orderItems[] = $orderItem;
    }
    
    public function getOrderItems() {
        return $this->orderItems;
    }

    /**
     * Builds subtotal, sans taxes, of this order
     *
     * @return float
     */
    public function subtotal() {
        
        $subtotal = 0.0;

        foreach ($this->orderItems as $orderItem) {
            $subtotal += $orderItem->subtotal();
        }

        return $subtotal;
    }

    /**
     * Collects and returns all taxes of order items in this order
     *
     * @return float
     */
    public function allTaxes() {
        
        $taxes = 0.0;

        foreach ($this->orderItems as $orderItem) {
            $taxes += $orderItem->totalTax();
        }

        return $taxes;
    }

    /**
     * Returns the total amount of this order, items and taxes
     *
     * @return float
     */
    public function totalAmount() {
        
        return $this->subtotal() + $this->allTaxes();
    }

    /**
     * Factory method to build an order from a JSON array
     *
     * @see examples/input_1.json for a valid example
     *
     * @param array $jsonArray built from parse_json($input, true)
     * @return Order
     * 
     * @throws Exception if the json is invalid (light checking done), or
     *         for internal error when building the order
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
