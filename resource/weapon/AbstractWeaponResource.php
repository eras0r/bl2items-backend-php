<?php

require_once 'vendor/autoload.php';

/**
 * Abstract super class for all resources based on the weapon entity.
 */
class AbstractWeaponResource extends AbstractResource {

    protected function validate($weapon) {
        $errors = array();
        if (empty($weapon["name"])) {
            $errors["name"] = "Name is required";
        }
        // TODO add proepr validation
        return $errors;
    }

}
