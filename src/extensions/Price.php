<?php

namespace extensions;

use models\Product;

/**
 * Provides price calculations for products
 */
class Price {
   
    const TAX_RATE    = 0.1;
    const IMPORT_RATE = 0.05;

    const TAX_EXEMPT_CATEGORIES = [
        Product::CATEGORY_BOOK,
        Product::CATEGORY_FOOD,
        Product::CATEGORY_MEDICAL
    ];

    function __construct() {
    }


    function salesTax($product) {
    
        $this->validateProduct($product);

        if ($this->exemptFromSalesTax($product)) {
            return 0;
        }

        return $this->calculateTax($product->getPrice(), self::TAX_RATE);
    }
    
    function exemptFromSalesTax($product) {
        
        $this->validateProduct($product);

        return in_array($product->getCategory(), self::TAX_EXEMPT_CATEGORIES);
    }

    function importTax($product) {
     
        $this->validateProduct($product);

        if ($product->isImported())
            return $this->calculateTax($product->getPrice(), self::IMPORT_RATE);
        else
            return 0;
    }

    /**
     * Returns a percentage of price, rounded up to the nearest $0.05
     * 
     * ex: For an item at $14.99, 10% tax would be $1.499, and rounded would be $1.50
     * For an item at $17.01, 5% tax would be $0.8505, and rounded would be $0.85
     * 
     * @param float $price (ex: $14.99)
     * @param float $rate tax rate (ex: 0.05)
     * @return float tax rate given the rounding up rule
     */
    function calculateTax($price, $rate) {
       
        $taxFloatAmount = round($price * $rate, 2);

        if ($taxFloatAmount * 100 % 5 == 0)
            return $taxFloatAmount;
        
        /*
         if not cleanly divisible by 5 add the remaining cents to get to the next $0.05 increment
         ex:
            $taxFloatAmount  = 1.499
            $baseCents (149) = intval(1.499 * 100)
            $remainder (4)   = 149 % 5
            $taxFloatAmount (1.5) = (149 + (5 - 4)) / 100  
        */

        $baseCents = intval($taxFloatAmount * 100);     
        $remainder = $baseCents % 5; 
        
        $taxFloatAmount = ($baseCents + (5 - $remainder)) / 100;

        return $taxFloatAmount;
    }

    /**
     * Since PHP7 is lacking named parameters, check here
     *
     * @param models/Product $product
     * @return boolean true if $product is valid, throws Exception otherwise
     * @throws InvalidArgumentException if product isn't a valid Product
     */
    private function validateProduct($product) {

        if (!is_object($product)) {
            throw new \InvalidArgumentException(
                sprintf('product is not an object, is a %s', gettype($product)));
        }

        if (!$product instanceof Product) {
            throw new \InvalidArgumentException(
                sprintf('product is not instance of Product, is a %s', get_class($product)));
        }

        return true;
    }
}
