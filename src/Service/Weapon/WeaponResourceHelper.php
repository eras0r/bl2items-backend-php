<?php

namespace Bl2\Service\Weapon;

use Bl2\Model\AbstractEntity;
use Bl2\Model\DamageType;
use Bl2\Model\Manufacturer;
use Bl2\Model\Rarity;
use Bl2\Model\Weapon;
use Bl2\Service\AbstractResourceHelper;

/**
 * Resource helper class for the {@link Weapon} entity.
 */
class WeaponResourceHelper extends AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public function getEntityName() {
        return Weapon::entityName();
    }

    /**
     * Creates a instance of the entity on which this repository is based
     *
     * @param array $jsonData array holding the property values for the entity instance to be created.
     *
     * @return AbstractEntity a new entity object
     */
    public function createNewEntityInstance(array $jsonData) {
        $weapon = new Weapon($jsonData);
        $this->setReferencesEntityObjects($weapon, $jsonData);
        return $weapon;
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
        $entityObject->setDamage($this->getValueFromJsonData($jsonData, "damage"));
        $entityObject->setDamageMultiplier($this->getValueFromJsonData($jsonData, "damageMultiplier"));
        $entityObject->setAccuracy($this->getValueFromJsonData($jsonData, "accuracy"));
        $entityObject->setFireRate($this->getValueFromJsonData($jsonData, "fireRate"));
        $entityObject->setReloadSpeed($this->getValueFromJsonData($jsonData, "reloadSpeed"));
        $entityObject->setMagazineSize($this->getValueFromJsonData($jsonData, "magazineSize"));
        $entityObject->setElemDamage($this->getValueFromJsonData($jsonData, "elemDamage"));
        $entityObject->setElemChance($this->getValueFromJsonData($jsonData, "elemChance"));

        $this->setReferencesEntityObjects($entityObject, $jsonData);
    }

    /**
     * Loads a referenced entity object from the given jsonData of the root object.
     *
     * @param $jsonData array the array holding the json representation of the root entity object to set the foreign
     * @param $jsonDataKey string the key within the jsonData array which represents the foreign key to the entity object to be loaded.
     * @param $entityName string the name of the entity to be loaded
     *
     * @return null|object the loaded entity object
     */
    private function getReferencedEntityObject($jsonData, $jsonDataKey, $entityName) {
        $damageTypeJson = $this->getValueFromJsonData($jsonData, $jsonDataKey);
        return isset($damageTypeJson["id"]) ? $damageType = $this->getEntityManager()->find($entityName, $damageTypeJson["id"]) : null;
    }

    /**
     * Gets the referenced entity objects from the given jsonData and sets the on the given enityObject. Sub classes
     * need to override this method in order so deal with references on entity objects.
     *
     * @param $entityObject AbstractEntity the entity object to set the referenced entity objects on
     * @param $jsonData array the json data for to get the referenced entity objects from
     */
    protected function setReferencesEntityObjects($entityObject, $jsonData) {
        // get and set referenced entity objects
        $entityObject->setDamageType($this->getReferencedEntityObject($jsonData, "damageType", DamageType::entityName()));
        $entityObject->setManufacturer($this->getReferencedEntityObject($jsonData, "manufacturer", Manufacturer::entityName()));
        $entityObject->setRarity($this->getReferencedEntityObject($jsonData, "rarity", Rarity::entityName()));
        // TODO set as soon as weaponType entity is implemented
//        $entityObject->setType($this->getValueFromJsonData($jsonData, "type"));
    }
}
