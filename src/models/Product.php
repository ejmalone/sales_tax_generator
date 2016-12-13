<?php

namespace models;

use extensions\Price;

class Product {

    const CATEGORY_BOOK    = 'book';
    const CATEGORY_CD      = 'cd';
    const CATEGORY_FOOD    = 'food';
    const CATEGORY_MEDICAL = 'medical';
    const CATEGORY_BEAUTY  = 'beauty';

    const ALL_CATEGORIES = [
        self::CATEGORY_BOOK,
        self::CATEGORY_CD,
        self::CATEGORY_FOOD,
        self::CATEGORY_MEDICAL,
        self::CATEGORY_BEAUTY
    ];

    private $priceExtension;

    private $price;

    private $category;

    private $isImported;

    function __construct() {

        $this->priceExtension = new Price();      
    }

    /**
     * Generic population of model attributes whether from database, API, etc
     * 
     * @param array $options contains keys for properties to set on this object
     * @return boolean true if successfully initialized, else exception thrown
     * @throws InvalidArgumentException that bubbles up from validation
     */
    public function initialize(array $options = []) {

        $this->validateInitializationOptions($options);

        $this->price = $options['price'];
        $this->category   = $options['category'];
        $this->isImported = $options['isImported'];

        return true;
    }


    /**
     * Validates model properties to ensure data integrity 
     * 
     * @param array $options contains keys for the properties to set on this object
     * @return null
     * @throws InvalidArgumentException if any options fail to validate
     */
    private function validateInitializationOptions($options) {

        if (empty($options) || !is_array($options)) {
   
            throw new \InvalidArgumentException('options for Product must be an array');
        }
      
        if (!isset($options['price']) ||
            empty($options['price'])  ||
            !(is_int($options['price']) || is_float($options['price'])) || 
            $options['price'] <= 0) {

            throw new \InvalidArgumentException('price must be a positive integer or float');
        }

        if (empty($options['category'])      ||
            !is_string($options['category']) || 
            !in_array($options['category'], self::ALL_CATEGORIES)) {

            throw new \InvalidArgumentException('category must be set and of an available Product category');
        }

        if (!isset($options['isImported']) ||
            !is_bool($options['isImported'])) {

            throw new \InvalidArgumentException('isImported must be set and a boolean');
        }

        if (!isset($options['name']) || 
            empty($options['name'])  || 
            !is_string($options['name'])) {
            
            throw new \InvalidArgumentException('name must be set and a valid string');
        }
    }


    public function getPrice() {
        return $this->price;
    }

    public function getCategory() {
        return $this->category;
    }

    public function isImported() {
        return $this->isImported;
    }


    /**
     * Automagic handling for our included extensions
     */
    function __call(string $name, array $arguments) {

        switch ($name) {

            case 'subtotal':
                return $this->priceExtension->$name($this, $arguments);

        default:
            throw new \BadMethodCallException(sprintf('Undefined method %s invoked from Product->__call', $name)); 

        }
    }
}
