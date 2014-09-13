<?php

namespace Bl2\Service\Rarity;

use Bl2\Model\AbstractEntity;
use Bl2\Model\Rarity;
use Bl2\Service\AbstractResourceHelper;

/**
 * Resource helper class for the {@link Rarity} entity.
 */
class RarityResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return Rarity::entityName();
    }

    /**
     * Creates a instance of the entity on which this repository is based
     *
     * @param array $jsonData array holding the property values for the entity instance to be created.
     *
     * @return AbstractEntity a new entity object
     */
    public function createNewEntityInstance(array $jsonData) {
        return new Rarity($jsonData);
    }

    /**
     * Updates the given entity with the values of the given JSON data object
     *
     * @param AbstractEntity $entityObject the entity object to be updated
     * @param $jsonData array the JSON data to be set to the entity object.
     *
     * @return mixed AbstractEntity the updated entity object
     */
    public function updateEntityObject(AbstractEntity $entityObject, $jsonData) {
        $entityObject->setName($this->getValueFromJsonData($jsonData, "name"));
        $entityObject->setColor($this->getValueFromJsonData($jsonData, "color"));
        $entityObject->setSortOrder($this->getValueFromJsonData($jsonData, "sortOrder"));
    }
}
