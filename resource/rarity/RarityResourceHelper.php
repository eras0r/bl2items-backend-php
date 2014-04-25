<?php

require_once 'model/Rarity.php';

/**
 * Resource helper class for the {@link Rarity} entity.
 */
class RarityResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return Rarity::getEntityName();
    }

    /**
     * Creates a instance of the entity on which this repository is based
     *
     * @param array $properties array holding the property values for the entity instance to be created.
     *
     * @return AbstractEntity a new entity object
     */
    public function createNewEntityInstance(array $properties) {
        return new Rarity($properties);
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
        $entityObject->setName($this->getValueFromJsonData($jsonData, "name"));
        $entityObject->setColor($this->getValueFromJsonData($jsonData, "color"));
        $entityObject->setSortOrder($this->getValueFromJsonData($jsonData, "sortOrder"));
    }
}
