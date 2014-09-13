<?php

namespace Bl2\Service;

use Bl2\Model\AbstractEntity;
use Bl2\Util\EntityManagerFactory;

/**
 * Abstract resource helper, which is responsible for creating and validating entity objects.
 * There is a concrete implementation for each entity of this class.
 */
abstract class AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public abstract function getEntityName();

    /**
     * Creates a instance of the entity on which this repository is based
     *
     * @param array $jsonData array holding a json representation of the  values for the entity instance to be created.
     *
     * @return AbstractEntity a new entity object
     */
    public abstract function createNewEntityInstance(array $jsonData);

    /**
     * Updates the given entity with the values of the given JSON data object
     *
     * @param AbstractEntity $entityObject the entity object to be updated
     * @param $jsonData mixed the JSON data to be set to the entity object.
     */
    public abstract function updateEntityObject(AbstractEntity $entityObject, $jsonData);

    /**
     * Gets the value with the given key $key from the given json array $jsonData
     *
     * @param $jsonData array the json array
     * @param $key string the key within the json array
     *
     * @return mixed the value with the given from the given json data array if the key existing,
     * or null if the key is not existing.
     */
    protected function getValueFromJsonData($jsonData, $key) {
        return (isset($jsonData[$key])) ? $jsonData[$key] : null;
    }

    /**
     * Gets the entity manager.
     * @return \Doctrine\ORM\EntityManager the entity manager
     */
    public function getEntityManager() {
        return EntityManagerFactory::getEntityManager();
    }

    /**
     * Gets the referenced entity objects from the given jsonData and sets the on the given enityObject. Sub classes
     * need to override this method in order so deal with references on entity objects.
     *
     * @param $entityObject AbstractEntity the entity object to set the referenced entity objects on
     * @param $jsonData array the json data for to get the referenced entity objects from
     */
    protected function setReferencesEntityObjects($entityObject, $jsonData) {
    }
}
