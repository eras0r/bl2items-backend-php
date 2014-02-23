<?php

require_once 'vendor/autoload.php';

/**
 * Abstract super class for all resources based on the {@link Manufacturer} entity.
 */
class AbstractManufacturerResource extends AbstractResource {

    protected function validate($damageType) {
        $errors = array();
        if (empty($damageType["name"])) {
            $errors["name"] = "Name is required";
        }
        return $errors;
    }

}
