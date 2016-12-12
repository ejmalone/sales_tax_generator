<?php

namespace models;

use extensions\Price;

class Product {

   private $price;

   function __construct(array $options) {

      $this->price = new Price();      
   }


   function __call(string $name, array $arguments) {
      
      switch ($name) {
         
         case 'subtotal':
            return $this->price->$name($this, $arguments);
            
         default:
            throw new \BadMethodCallException(sprintf('Undefined method %s invoked from Product->__call', $name)); 

      }
   }
}
