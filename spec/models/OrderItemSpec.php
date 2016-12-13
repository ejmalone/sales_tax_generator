<?php

namespace spec\models;

use models\OrderItem;
use models\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderItemSpec extends ObjectBehavior {

    function it_is_initializable() {

        $this->shouldHaveType(OrderItem::class);
    }

    function it_throws_an_exception_if_invalid_quantity_of_products_is_added(Product $product) {

        $this->shouldThrow('\InvalidArgumentException')->duringSetProductAndQuantity($product, 0);
        $this->shouldThrow('\InvalidArgumentException')->duringSetProductAndQuantity($product, -1);
    }

    function it_generates_subtotal_for_multiple_products(Product $product) {
        
        $product->getPrice()->willReturn(14.5);

        $this->setProductAndQuantity($product, 2);

        $this->subtotal()->shouldReturn(29.0);
    }

    function it_calculates_total_tax_for_a_single_product(Product $product) {

        $product->totalTaxes()->willReturn(1.0);
        
        $this->setProductAndQuantity($product, 1);

        $this->totalTax()->shouldReturn(1.0);
    }
    
    function it_calculates_total_tax_for_multiple_products(Product $product) {
        
        $product->totalTaxes()->willReturn(1.0);

        $this->setProductAndQuantity($product, 2);

        $this->totalTax()->shouldReturn(2.0);
    }

}
