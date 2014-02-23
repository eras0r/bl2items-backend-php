<?php

require_once 'vendor/autoload.php';

/**
 * Abstract super class for all resources based on the {@link DamageType} entity.
 */
class AbstractDamageTypeResource extends AbstractResource {

    /**
     * Validates the given damage type associative array.
     * @param $damageType associative array containing the object to be validated
     * @return array associative array containing validation errors (if any).
     */
    protected function validate($damageType) {
        $errors = array();
        if (empty($damageType["name"])) {
            $errors["name"] = "Name is required";
        }
        if (empty($damageType["sortOrder"])) {
            $errors["sortOrder"] = "Sort order is required";
        }
        return $errors;
    }

}
