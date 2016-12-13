<?php

namespace spec\extensions;

use models\Product;
use extensions\Price;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceSpec extends ObjectBehavior {

    function createProduct($category, $price, $isImported) {
        $product = new Product();
        $product->initialize([
            'category'   => $category,
            'price'      => $price,
            'isImported' => $isImported,
            'name'       => 'test product'
        ]);

        return $product;
    }

    function it_is_initializable() {
        $this->shouldHaveType(Price::class);
    }

    function it_should_not_tax_for_exempt_categories() {
         
        $product = $this->createProduct(Product::CATEGORY_CD, 20, false);

        $this->exemptFromSalesTax($product)->shouldReturn(false);
    }
    
    function it_should_tax_for_non_exempt_categories() {
         
        $product = $this->createProduct(Product::CATEGORY_BOOK, 20, false);

        $this->exemptFromSalesTax($product)->shouldReturn(true);
    }

    function it_should_add_import_tax_for_imported_goods() {

        $product = $this->createProduct(Product::CATEGORY_BOOK, 20, true);

        $this->importTax($product)->shouldReturn(1.0);
    }
    
    function it_should_not_add_import_tax_for_local_goods() {

        $product = $this->createProduct(Product::CATEGORY_BOOK, 20, false );

        $this->importTax($product)->shouldReturn(0);
    }

    function it_should_round_up_for_partial_tax_amounts() {
        
        $this->calculateTax(14.99, .1)->shouldReturn(1.5);   // real is .1499
        $this->calculateTax(14.99, .05)->shouldReturn(0.75); // real is .7495 
        $this->calculateTax(17.01, .05)->shouldReturn(.85);  // real is .8505
        $this->calculateTax(7.77, .03)->shouldReturn(.25);   // real is .2331
    }

    function it_should_not_round_for_tax_amounts_divisible_by_five() {

        $this->calculateTax(15, .05)->shouldReturn(0.75);
    }

}
