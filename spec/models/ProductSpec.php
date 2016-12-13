<?php

namespace spec\models;

use models\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior {

    function getValidOptions() {
        return ['price' => 100,
                'category'   => Product::CATEGORY_BOOK,
                'isImported' => true];
    }

    function it_is_initializable() {
        $this->shouldHaveType(Product::class);
    }

    function it_should_fail_initialization_without_options_arg() {

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize();
    }
    
    function it_should_fail_initialization_without_price() {

      $options = $this->getValidOptions();
      unset($options['price']);

      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
      
    }

    function it_should_fail_initialization_with_non_numeric_price() {

      $options = $this->getValidOptions();
      $options['price'] = 'abc';
      
      $this->shouldThrow('\InvalidArgumentException')->duringInitialize($options);
    }

    function it_should_fail_initialization_with_negative_price() {

      $options = $this->getValidOptions();
      $options['price'] = -1;

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
