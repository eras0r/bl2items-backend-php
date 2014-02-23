<?php

require_once 'vendor/autoload.php';

require_once 'model/Rarity.php';

/**
 * Abstract super class for all resources based on the {@link Rarity} enity.
 */
class AbstractRarityResource extends AbstractResource {

    /**
     * Gets the entity name for the ORM mapper on which this resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    protected function getEnityName() {
        return Rarity::getEntityName();
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
        if (empty($damageType["color"])) {
            $errors["color"] = "Color is required";
        }
        if (empty($damageType["sortOrder"])) {
            $errors["sortOrder"] = "Sort order is required";
        }
        return $errors;
    }

}
