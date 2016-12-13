<?php

namespace spec\models;

use models\OrderItem;
use models\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderItemSpec extends ObjectBehavior {

    /**
     * Since a double passed to our tests below won't have the proxied
     * Price extension, we'll generate real products here
     */
    function generateTaxableProduct($price, $isImported) {
        
        $product = new Product();
        
        $product->initialize([
            'price' => $price,
            'name'  => 'foo',
            'category' => Product::CATEGORY_CD,
            'isImported' => $isImported
        ]);
        
        return $product;
    }

    function it_is_initializable() {

        $this->shouldHaveType(OrderItem::class);
    }

    function it_calculates_tax_for_a_single_product() {
        
        $product = $this->generateTaxableProduct(10, false);
        $this->setProductAndQuantity($product, 1);

        $this->getTotalTax()->shouldReturn(1.0);
    }
    
    function it_calculates_tax_for_multiple_products() {
        
        $product = $this->generateTaxableProduct(10, false);
        $this->setProductAndQuantity($product, 2);

        $this->getTotalTax()->shouldReturn(2.0);
    }

    function it_calculates_import_tax_for_multiple_products() {

        $product = $this->generateTaxableProduct(13.70, true);
        $this->setProductAndQuantity($product, 2);

        $this->getTotalTax()->shouldReturn(4.2);
    }

}
