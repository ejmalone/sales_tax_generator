<?php

namespace models;

use extensions\Price;

class Product {

    const CATEGORY_BOOK    = 'book';
    const CATEGORY_CD      = 'cd';
    const CATEGORY_FOOD    = 'food';
    const CATEGORY_MEDICAL = 'medical';
    const CATEGORY_BEAUTY  = 'beauty';

    /**
     * @var array a lookup table of all categories, used in validation
     */
    const ALL_CATEGORIES = [
        self::CATEGORY_BOOK,
        self::CATEGORY_CD,
        self::CATEGORY_FOOD,
        self::CATEGORY_MEDICAL,
        self::CATEGORY_BEAUTY
    ];

    /**
     * @var Price extension class used to calculate tax
     * @see proxied calls below
     */
    private $priceExtension;

    /**
     * @var float the price of this product
     */
    private $price;

    /**
     * @var string the category, matching one of the CATEGORY_* constants
     */
    private $category;
    
    /**
     * @var string the descriptive name of the product
     */
    private $name;

    /**
     * @var bool whether this product is imported
     */
    private $isImported;


    function __construct() {

        $this->priceExtension = new Price();      
    }

    /**
     * Generic population of model attributes, whether from database, API, etc
     * 
     * @param array $options contains keys for properties to set on this object
     * @return boolean true if successfully initialized, else exception thrown
     *
     * @throws InvalidArgumentException that bubbles up from validation
     */
    public function initialize(array $options) {

        $this->validateInitializationOptions($options);

        $this->price      = (float) $options['price'];
        $this->category   = $options['category'];
        $this->name       = $options['name'];
        $this->isImported = $options['isImported'];

        return true;
    }


    /**
     * Validates model properties to ensure data integrity 
     * 
     * @param array $options contains keys for the properties to set on this object
     * @return null
     *
     * @throws InvalidArgumentException if any options fail to validate
     */
    private function validateInitializationOptions(array $options) {

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
    
    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }

    public function isImported() {
        return $this->isImported;
    }

    /**
     * @return the total taxable price, including all taxes
     */
    public function taxablePrice() {
        return $this->getPrice() + $this->totalTaxes();
    }


    /** 
     ** Proxied methods to our Price extension. 
     ** Using __call() won't work since PHPSpec can't 'see' those methods
     **/

    function salesTax()           { return $this->priceExtension->salesTax($this); }
    function importTax()          { return $this->priceExtension->importTax($this); }
    function totalTaxes()         { return $this->priceExtension->totalTaxes($this); }
    function exemptFromSalesTax() { return $this->priceExtension->exemptFromSalesTax($this); }

}
