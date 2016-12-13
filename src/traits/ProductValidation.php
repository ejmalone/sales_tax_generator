<?php

namespace traits;

use models\Product;

trait ProductValidation {

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
