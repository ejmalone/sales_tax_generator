<?php

namespace models;

use models\OrderItem;
use traits\Validation;

class Order {
    
    use Validation;

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

    public function orderItems() {

    }

    public function collectTaxes() {
    
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

            var_dump($item);
            $product = new Product();
            $product->initialize($item);

            $orderItem = new OrderItem();
            $orderItem->setProductAndQuantity($product, $item['quantity']);

            $order->addOrderItem($orderItem);
        }

        return $order;
    }
}
