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
     * @param $jsonData mixed the JSON data to be set to the entity object.
     */
    public function updateEntityObject(AbstractEntity $entityObject, $jsonData) {
        $entityObject->setName($this->getValueFromJsonData($jsonData, "name"));
        $entityObject->setSortOrder($this->getValueFromJsonData($jsonData, "sortOrder"));
        $entityObject->setColor($this->getValueFromJsonData($jsonData, "color"));
        $entityObject->setDamageLabel($this->getValueFromJsonData($jsonData, "damageLabel"));
        $entityObject->setChanceLabel($this->getValueFromJsonData($jsonData, "chanceLabel"));
        $entityObject->setAdditionalText($this->getValueFromJsonData($jsonData, "additionalText"));
    }
}
