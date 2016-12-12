<?php

namespace spec\models;

use models\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior {

    function getValidOptions() {
        return ['priceCents' => 100,
                'category'   => Product::CATEGORY_BOOK,
                'isImported' => true];
    }

    function it_is_initializable() {
        $this->shouldHaveType(Product::class);
    }

    function it_should_fail_initialization_without_options_arg() {

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize();
    }
    
    function it_should_fail_initialization_without_priceCents() {

      $options = $this->getValidOptions();
      unset($options['priceCents']);

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
      
    }

    function it_should_fail_initialization_with_non_numeric_priceCents() {

      $options = $this->getValidOptions();
      $options['priceCents'] = 'abc';
      
      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }

    function it_should_fail_initialization_with_negative_priceCents() {

      $options = $this->getValidOptions();
      $options['priceCents'] = -1;

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }
     
    function it_should_fail_initialization_with_float_priceCents() {

      $options = $this->getValidOptions();
      $options['priceCents'] = .33;

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }
    
    function it_should_fail_initialization_without_category() {

      $options = $this->getValidOptions();
      unset($options['category']);

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }

    function it_should_fail_initialization_with_invalid_category() {

      $options = $this->getValidOptions();
      $options['category'] = 'foo';

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }
    
    function it_should_fail_initialization_without_isImported() {

      $options = $this->getValidOptions();
      unset($options['isImported']);

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }

    function it_should_fail_initialization_with_nonboolean_isImported() {

      $options = $this->getValidOptions();
      $options['isImported'] = 'foo';

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }


    function it_should_pass_initialization_with_valid_options() {

      $options = $this->getValidOptions();

      $this->initialize($options)->shouldReturn(true);
    }
}
