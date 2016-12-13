<?php

namespace spec\models;

use models\Invoice;
use models\Product;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvoiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Invoice::class);
    }

    function it_formats_floats() {
        
        $float = 12.0000;

        $this->formatFloat($float)->shouldReturn("12.00");
    }

    function it_formats_local_product_names(Product $product) {
    
        $productName = 'bunny slippers';

        $product->isImported()->willReturn(false);
        $product->getName()->willReturn($productName);

        $this->formattedName($product)->shouldReturn($productName);
    }
    
    function it_formats_imported_product_names(Product $product) {
    
        $productName = 'bunny slippers';
        $formattedName = 'imported ' . $productName;

        $product->isImported()->willReturn(true);
        $product->getName()->willReturn($productName);

        $this->formattedName($product)->shouldReturn($formattedName);
    }
}
