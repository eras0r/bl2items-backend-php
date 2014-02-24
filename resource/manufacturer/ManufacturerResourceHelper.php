<?php

require_once 'model/Manufacturer.php';

class ManufacturerResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return Manufacturer::getEntityName();
    }

    /**
     * Validates the given damage type associative array.
     * @param $entity associative array containing the entity object to be validated
     * @return array associative array containing validation errors (if any).
     */
    public function validate($entity) {
        $errors = array();
        if (empty($entity["name"])) {
            $errors["name"] = "Name is required";
        }
        return $errors;
    }

    /**
     *
     * Creates a instance of the entity on which this repository is based
     * @param array $properties array holding the property values for the entity instance to be created.
     * @return AbstractEntity a new entity object
     */
    public function createNewEntityInstance(array $properties) {
        return new Manufacturer($properties);
    }

}
