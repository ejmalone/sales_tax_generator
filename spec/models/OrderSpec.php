<?php

namespace spec\models;

use models\Order;
use models\OrderItem;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Order::class);
    }

    function it_generates_valid_subtotal_from_order_items(OrderItem $one, OrderItem $two) {
        
        $subtotal1 = 12.35;
        $subtotal2 = 14.00;
        $subtotalAmt = $subtotal1 + $subtotal2;

        $one->subtotal()->willReturn($subtotal1);
        $two->subtotal()->willReturn($subtotal2);

        $this->addOrderItem($one);
        $this->addOrderItem($two);

        $this->subtotal()->shouldReturn($subtotalAmt);
    }
    
    function it_generates_valid_taxes_from_order_items(OrderItem $one, OrderItem $two) {
        
        $tax1 = 1.15;
        $tax2 = 3.20;
        $taxAmt = $tax1 + $tax2;

        $one->totalTax()->willReturn($tax1);
        $two->totalTax()->willReturn($tax2);

        $this->addOrderItem($one);
        $this->addOrderItem($two);

        $this->allTaxes()->shouldReturn($taxAmt);
    }

    function it_generates_total_amount_from_subtotal_and_taxes(OrderItem $one, OrderItem $two) {
        
        $subtotal1 = 12.35;
        $subtotal2 = 14.00;
        $subtotalAmt = $subtotal1 + $subtotal2;

        $tax1 = 1.15;
        $tax2 = 3.20;
        $taxAmt = $tax1 + $tax2;

        $totalAmount = $subtotalAmt + $taxAmt;

        $one->totalTax()->willReturn($tax1);
        $two->totalTax()->willReturn($tax2);
        
        $one->subtotal()->willReturn($subtotal1);
        $two->subtotal()->willReturn($subtotal2);

        $this->addOrderItem($one);
        $this->addOrderItem($two);
        
        $this->totalAmount()->shouldReturn($totalAmount);
    }
}
