<?php

require_once 'model/Manufacturer.php';

/**
 * Resource helper class for the {@link Manufacturer} entity.
 */
class ManufacturerResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return Manufacturer::getEntityName();
    }

    /**
     * Validates the given associative array which holds the entity object's properties.
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

    /**
     * Updates the given entity with the values of the given JSON data object
     * @param AbstractEntity $entityObject the entity object to be updated
     * @param $jsonData the JSON data to be set to the entity object.
     * @return mixed
     */
    public function updateEntityObject(AbstractEntity $entityObject, $jsonData) {
        $entityObject->setName($jsonData["name"]);
    }

}
