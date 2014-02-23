<?php

require_once 'vendor/autoload.php';

require_once "model/Manufacturer.php";

/**
 * Abstract super class for all RESTfulresources based on the {@link Manufacturer} entity.
 */
class AbstractManufacturerResource extends AbstractResource {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    protected function getEnityName() {
        return Manufacturer::getEntityName();
    }

    /**
     * Validates the given damage type associative array.
     * @param $entity associative array containing the entity object to be validated
     * @return array associative array containing validation errors (if any).
     */
    protected function validate($entity) {
        $errors = array();
        if (empty($damageType["name"])) {
            $errors["name"] = "Name is required";
        }
        return $errors;
    }

}
