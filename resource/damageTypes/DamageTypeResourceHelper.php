<?php

require_once 'model/DamageType.php';

/**
 * Resource helper class for the {@link DamageType} entity.
 */
class DamageTypeResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return DamageType::getEntityName();
    }

    /**
     * Validates the given associative array which holds the entity object's properties.
     *
     * @param $entity associative array containing the entity object to be validated
     *
     * @return array associative array containing validation errors (if any).
     */
    public function validate($entity) {
        $errors = array();
        if (empty($entity["name"])) {
            $errors["name"] = "Name is required";
        }
        if (empty($entity["sortOrder"])) {
            $errors["sortOrder"] = "Sort order is required";
        }
        return $errors;
    }

    /**
     * Creates a instance of the entity on which this repository is based
     *
     * @param array $properties array holding the property values for the entity instance to be created.
     *
     * @return AbstractEntity a new entity object
     */
    public function createNewEntityInstance(array $properties) {
        return new DamageType($properties);
    }

    /**
     * Updates the given entity with the values of the given JSON data object
     *
     * @param AbstractEntity $entityObject the entity object to be updated
     * @param $jsonData the JSON data to be set to the entity object.
     *
     * @return mixed AbstractEntity the updated entity object
     */
    public function updateEntityObject(AbstractEntity $entityObject, $jsonData) {
        $entityObject->setName($jsonData["name"]);
        $entityObject->setSortOrder($jsonData["sortOrder"]);
    }
}
