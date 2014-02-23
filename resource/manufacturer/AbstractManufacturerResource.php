<?php

require_once 'vendor/autoload.php';

/**
 * Abstract super class for all resources based on the rarity enity.
 */
class AbstractManufacturerResource extends AbstractResource {

    protected function validate($rarity) {
        $errors = array();
        if (empty($rarity["name"])) {
            $errors["name"] = "Name is required";
        }
        if (empty($rarity["color"])) {
            $errors["color"] = "Color is required";
        }
        if (empty($rarity["sortOrder"])) {
            $errors["sortOrder"] = "Sort order is required";
        }
        return $errors;
    }

}
