<?php

namespace traits;

trait Validation {

    function validateInstanceOf($object, $klassname, $name) {
        
        if (!is_object($object)) {
            throw new \InvalidArgumentException(
                sprintf('passed %s is not an object, but is an %s', $name, gettype($object))); 
        }


        if (get_class($object) != $klassname) {
            throw new \InvalidArgumentException(
                sprintf('passed %s is not an instance of %s, but is an %s', $name, $klassname, get_class($object)));

        }
    }
}
