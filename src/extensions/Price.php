<?php

namespace extensions;

use models\Product;

/**
 * Provides price calculations for products. 
 * 
 * While related to Products, it is provided as a distinct library for ease of
 * use elsewhere, to prevent bloat in the Product class, and allow further
 * expansion on tax and exemption abilities (e.g. loading from database).
 *
 * The class is proxied within the Product class for developers' ease to call 
 * methods against tax calculation, etc.
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


    function salesTax(Product $product) {
    
        if ($this->exemptFromSalesTax($product)) {
            return 0;
        }

        return $this->calculateTax($product->getPrice(), self::TAX_RATE);
    }
    
    function exemptFromSalesTax(Product $product) {
        
        return in_array($product->getCategory(), self::TAX_EXEMPT_CATEGORIES);
    }

    function importTax(Product $product) {
     
        if ($product->isImported())
            return $this->calculateTax($product->getPrice(), self::IMPORT_RATE);
        else
            return 0;
    }

    function totalTaxes(Product $product) {

        return $this->salesTax($product) + $this->importTax($product);
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
    function calculateTax(float $price, float $rate) {
       
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

}
