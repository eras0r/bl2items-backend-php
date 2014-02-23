<?php

require_once 'vendor/autoload.php';

/**
 * Abstract super class for all resources based on the weapon entity.
 */
class AbstractWeaponResource extends AbstractResource {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    protected function getEnityName() {
        // TODO: Implement getEnityName() method.
    }

    /**
     * Validates the given damage type associative array.
     * @param $entity associative array containing the entity object to be validated
     * @return array associative array containing validation errors (if any).
     */
    protected function validate($entity) {
        $errors = array();
        if (empty($weapon["name"])) {
            $errors["name"] = "Name is required";
        }
        // TODO add proper validation
        return $errors;
    }

}
